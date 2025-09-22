<div class="product-catalog">
    @foreach($products as $product)
        <livewire:product-card :product="$product" :wire:key="'product-'.$product->id" />
    @endforeach
</div>