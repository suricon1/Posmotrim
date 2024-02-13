@if($looks)
    <div class="Related-product mt-105 mb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-35">
                        <h3>Вы недавно смотрели</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="product-slider-active">
                    @foreach($looks as $product)
                        <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12">

                            @include('vinograd.components.single-product-item', ['product' => $product])

                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endif
