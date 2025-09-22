<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Pest\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    { try {
            // Rate limiting untuk mencegah brute force attack
            $this->checkRateLimit($request);

            // Validasi input
            $credentials = $this->validateLoginRequest($request);

            // Attempt login
            if ($this->attemptLogin($request, $credentials)) {
                return $this->handleSuccessfulLogin($request);
            }

            // Login gagal
            return $this->handleFailedLogin($request);

        } catch (ValidationException $e) {
            // Validation error akan di-handle otomatis oleh Laravel
            throw $e;
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Login error: ' . $e->getMessage(), [
                'email' => $request->email ?? 'not provided',
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput($request->only('email', 'remember'))
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi administrator.');
        }
    }
     private function validateLoginRequest(Request $request)
    {
        return $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'password' => [
                'required',
                'min:8',
                'max:255'
            ],
            'remember' => 'boolean'
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.regex' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.max' => 'Password maksimal 255 karakter.'
        ]);
    }

    /**
     * Check rate limit untuk mencegah brute force
     */
    private function checkRateLimit(Request $request)
    {
        $key = 'login.' . $request->ip();
        $maxAttempts = 5; // Maksimal 5 percobaan
        $decayMinutes = 15; // Dalam 15 menit

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            $minutes = ceil($seconds / 60);
            
            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$minutes} menit."
            ]);
        }

        RateLimiter::hit($key, $decayMinutes * 60);
    }

    /**
     * Attempt to log the user in
     */
    private function attemptLogin(Request $request, array $credentials)
    {
        try {
            return Auth::attempt(
                $credentials,
                $request->boolean('remember')
            );
        } catch (\Exception $e) {
            Log::error('Auth attempt error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Handle successful login
     */
    private function handleSuccessfulLogin(Request $request)
    {
        try {
            // Regenerate session untuk keamanan
            $request->session()->regenerate();
            
            // Clear rate limiter
            RateLimiter::clear('login.' . $request->ip());
            
            // Log successful login
            Log::info('User logged in successfully', [
                'user_id' => Auth::id(),
                'email' => Auth::user()->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Check user role dan redirect
            $user = Auth::user();
            
            if (!$user) {
                throw new \Exception('User data not found after authentication');
            }

            // Pastikan user memiliki role
            if (!isset($user->role) || empty($user->role)) {
                Log::warning('User without role attempted login', ['user_id' => $user->id]);
                Auth::logout();
                return back()->with('error', 'Akun Anda belum memiliki role yang valid. Hubungi administrator.');
            }

            // Redirect berdasarkan role
            switch ($user->role) {
                case 'admin':
                    return redirect()->intended(route('admin.dashboard'))
                        ->with('success', 'Selamat datang, Admin!');
                    
                case 'user':
                    return redirect()->intended(route('products.index'))
                        ->with('success', 'Login berhasil! Selamat datang kembali.');
                    
                default:
                    Log::warning('User with unknown role attempted login', [
                        'user_id' => $user->id,
                        'role' => $user->role
                    ]);
                    Auth::logout();
                    return back()->with('error', 'Role akun tidak dikenal. Hubungi administrator.');
            }

        } catch (\Exception $e) {
            Log::error('Error handling successful login: ' . $e->getMessage());
            Auth::logout();
            return back()->with('error', 'Terjadi kesalahan setelah login. Silakan coba lagi.');
        }
    }

    /**
     * Handle failed login
     */
    private function handleFailedLogin(Request $request)
    {
        // Log failed login attempt
        Log::warning('Failed login attempt', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return back()
            ->withErrors(['email' => 'Email atau password yang Anda masukkan salah.'])
            ->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
      try {
            // Rate limiting untuk mencegah spam registrasi
            $this->checkRateLimit($request);

            // Validasi input
            $validatedData = $this->validateRegistrationRequest($request);

            // Cek duplikasi email dan phone
            $this->checkDuplicateData($validatedData);

            // Buat user baru
            $user = $this->createUser($validatedData);

            // Login otomatis setelah registrasi
            $this->loginUser($user, $request);

            // Clear rate limiter
            RateLimiter::clear('register.' . $request->ip());

            // Log successful registration
            Log::info('New user registered successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return redirect()->route('products.index')
                ->with('success', 'Selamat! Akun Anda berhasil dibuat. Selamat datang di CV. Axel Digital Creative!');

        } catch (ValidationException $e) {
            // Validation error akan di-handle otomatis oleh Laravel
            throw $e;
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Registration error: ' . $e->getMessage(), [
                'email' => $request->email ?? 'not provided',
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi administrator.');
        }
    }
     private function validateRegistrationRequest(Request $request)
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'phone' => [
                'required',
                'string',
                'min:10',
                'max:15',
                'unique:users,phone',
                'regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/'
            ],
            'address' => [
                'required',
                'string',
                'min:10',
                'max:500'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:255',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
        ], [
            // Custom error messages
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.min' => 'Nama minimal 2 karakter.',
            'name.max' => 'Nama maksimal 100 karakter.',
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
            
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar. Silakan gunakan email lain.',
            'email.regex' => 'Format email tidak valid.',
            
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.min' => 'Nomor telepon minimal 10 digit.',
            'phone.max' => 'Nomor telepon maksimal 15 digit.',
            'phone.unique' => 'Nomor telepon sudah terdaftar. Silakan gunakan nomor lain.',
            'phone.regex' => 'Format nomor telepon tidak valid. Gunakan format: 08xxxxxxxxxx',
            
            'address.required' => 'Alamat wajib diisi.',
            'address.min' => 'Alamat minimal 10 karakter.',
            'address.max' => 'Alamat maksimal 500 karakter.',
            
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.regex' => 'Password harus mengandung minimal 1 huruf kecil, 1 huruf besar, dan 1 angka.',
        ]);
    }


    /**
     * Check for duplicate data
     */
    private function checkDuplicateData(array $data)
    {
        // Double check untuk email (meskipun sudah ada di validasi)
        $existingEmail = User::where('email', $data['email'])->first();
        if ($existingEmail) {
            throw ValidationException::withMessages([
                'email' => 'Email sudah terdaftar. Silakan gunakan email lain atau masuk dengan akun yang ada.'
            ]);
        }

        // Double check untuk phone
        $existingPhone = User::where('phone', $data['phone'])->first();
        if ($existingPhone) {
            throw ValidationException::withMessages([
                'phone' => 'Nomor telepon sudah terdaftar. Silakan gunakan nomor lain.'
            ]);
        }
    }

    /**
     * Create new user
     */
    private function createUser(array $data)
    {
        try {
            DB::beginTransaction();

            // Normalize phone number
            $phone = $this->normalizePhoneNumber($data['phone']);

            $user = User::create([
                'name' => trim($data['name']),
                'email' => strtolower(trim($data['email'])),
                'phone' => $phone,
                'address' => trim($data['address']),
                'password' => Hash::make($data['password']),
                'role' => 'user', // Default role
                'email_verified_at' => now(), // Auto verify untuk simplicity
            ]);

            DB::commit();
            return $user;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating user: ' . $e->getMessage());
            throw new \Exception('Gagal membuat akun. Silakan coba lagi.');
        }
    }

    /**
     * Normalize phone number format
     */
    private function normalizePhoneNumber($phone)
    {
        // Remove any spaces or dashes
        $phone = preg_replace('/[\s-]/', '', $phone);
        
        // Convert +62 to 0
        if (strpos($phone, '+62') === 0) {
            $phone = '0' . substr($phone, 3);
        } elseif (strpos($phone, '62') === 0) {
            $phone = '0' . substr($phone, 2);
        }
        
        return $phone;
    }

    /**
     * Login user after registration
     */
    private function loginUser(User $user, Request $request)
    {
        try {
            Auth::login($user);
            $request->session()->regenerate();
        } catch (\Exception $e) {
            Log::error('Error logging in user after registration: ' . $e->getMessage());
            // Tidak throw error karena user sudah terbuat, hanya login yang gagal
        }
    }

    /**
     * Check if user exists (untuk AJAX check)
     */
    public function checkUser(Request $request)
    {
        try {
            $field = $request->get('field');
            $value = $request->get('value');

            if (!in_array($field, ['email', 'phone'])) {
                return response()->json(['error' => 'Invalid field'], 400);
            }

            $exists = User::where($field, $value)->exists();

            return response()->json(['exists' => $exists]);

        } catch (\Exception $e) {
            Log::error('Error checking user existence: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
}
