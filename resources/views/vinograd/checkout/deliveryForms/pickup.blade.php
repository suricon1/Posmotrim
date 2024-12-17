<div class="col-md-12">
    <div class="checkout-form-list">
        <label><span class="required">*</span> Имя</label>
        <input placeholder="" type="text" name="customer[name]" class="form-control{{ $errors->first('customer.name') ? ' is-invalid' : '' }}" value="{{ old('customer.name', $user && $user->delivery ? $user->delivery['first_name'] : '') }}" id="customer[name]">
        <div class="invalid-feedback" id="invalid-customer[name]">
            {{ $errors->first('customer.name') ? $errors->first('customer.name') : '' }}
        </div>
    </div>
</div>
