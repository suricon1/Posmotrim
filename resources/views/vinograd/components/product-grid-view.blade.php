<div class="product-grid-view">
    <div class="row">

        @foreach($products as $product)

            <div class="col-xl-4 col-md-6">
                @include('vinograd.components.single-product-item', ['product' => $product])
            </div>

        @endforeach

    </div>
</div>
