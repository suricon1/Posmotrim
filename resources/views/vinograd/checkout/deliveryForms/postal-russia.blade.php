<div class="col-md-12">
    <div class="checkout-form-list">
        <label><span class="required">*</span> Фамилия Имя Отчество (Необходимо для заполнения почтовой формы)</label>
        <input placeholder="" type="text" name="customer[name]" class="form-control{{ $errors->first('customer.name') ? ' is-invalid' : '' }}" value="{{ old('customer.name', $user && $user->delivery ? $user->delivery['first_name'] : '') }}" id="customer[name]">
        <div class="invalid-feedback" id="invalid-customer[name]">
            {{ $errors->first('customer.name') ? $errors->first('customer.name') : '' }}
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="checkout-form-list">
        <label><span class="required">*</span> Индекс Вашей почты</label>
        <input placeholder="" type="text" name="delivery[index]" class="form-control{{ $errors->first('delivery.index') ? ' is-invalid' : '' }}" value="{{ old('delivery.index', $user && $user->delivery ? $user->delivery['index'] : '') }}" id="delivery[index]">
        <div class="invalid-feedback" id="invalid-delivery[index]">
            {{ $errors->first('delivery.index') ? $errors->first('delivery.index') : '' }}
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="checkout-form-list">
        <label><span class="required">*</span> Адрес</label>
        <input placeholder="" type="text" name="delivery[address]" class="form-control{{ $errors->first('delivery.address') ? ' is-invalid' : '' }}" value="{{ old('delivery.address', $user && $user->delivery ? $user->delivery['address'] : '') }}" id="delivery[address]">
        <div class="invalid-feedback" id="invalid-delivery[address]">
            {{ $errors->first('delivery.address') ? $errors->first('delivery.address') : '' }}
        </div>
    </div>
</div>

