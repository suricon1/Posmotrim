<div class="card card-default collapsed-card" style="margin-bottom: 5px!important;">

    <div class="card-header" style="padding: 5px">
        <button type="button" class="btn btn-tool" data-widget="collapse">
            <h5 class="card-title">
                <i class="right fa fa-angle-right"></i>
                {{$modification->property->name}}:
                <span class="text-danger" id="modification_{{$modification->id}}_quantity">{{$modification->quantity}}</span> шт -
                <span class="text-danger" id="modification_{{$modification->id}}_price">{{$modification->price}}</span> руб
            </h5>
        </button>
    </div>
    <div class="card-body">
        <div class="form-group">
            <input type="hidden" name="modification_id" value="{{$modification->id}}">
            <div class="input-group input-group-sm mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">Цена</span>
                </div>
                <input type="number" name="price" value="{{$modification->price}}" class="form-control">
                <div class="input-group-prepend">
                    <span class="input-group-text">руб</span>
                </div>
            </div>
            <div class="input-group input-group-sm mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon2">коррекция <strong>( + / - )</strong></span>
                </div>
                <input type="number" name="correct" value="0" class="form-control">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">шт</span>
                </div>
            </div>
            <button class="btn btn-primary modification-update" type="button" data-url="{{route('products.modification.edit')}}">
                <i class="fa fa-refresh"></i>
            </button>
        </div>
    </div>
</div>
