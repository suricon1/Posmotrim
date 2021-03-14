<div class="input-group input-group-sm mb-2">
    <input type="hidden" name="modification_id" value="{{$modification->id}}">
    <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">{{$modification->property->name}}</span>
        <span class="input-group-text" id="">Цена</span>
    </div>
    <input type="number" name="price" value="{{$modification->price}}" class="form-control">
    <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon2">шт</span>
    </div>
    <input type="number" name="quantity" value="{{$modification->quantity}}" class="form-control">
    <div class="input-group-append" id="button-addon4">
        <button class="btn btn-outline-secondary modification-update" type="button" data-url="{{route('products.modification.edit')}}"><i class="fa fa-refresh"></i></button>
{{--        <button class="btn btn-outline-secondary modification-remove" type="button"data-url="{{route('products.modification.delete')}}"><i class="fa fa-times"></i></button>--}}
    </div>
</div>
