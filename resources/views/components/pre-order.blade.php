{!! Form::open(['id' => 'pre-order-form']) !!}
    <div class="modal-body">
        <div class="alert alert-info" role="alert">
            <span class="fa-stack fa-2x float-left" style="margin-right: .75rem;">
              <i class="fa fa-circle-thin fa-stack-2x"></i>
              <i class="fa fa-info fa-stack-1x"></i>
            </span>
            <h4 style="line-height: 1.6;">Уважаемые посетители нашего сайта, если Вы не успели в сезон купить нужный черенок или саженец, мы рады продложить Вам возможность сделать предзаказ посадочного материала на весну - осень следующего сезона.</h4>
        </div>
        <div class="form-row mb-3">
            <div class="col-12">
                <label><i class="fa fa-asterisk text-danger"></i> <strong>Ваше имя</strong></label>
                <input name="name" type="text" class="form-control" value="{{($pre_order) ? $pre_order->name : ''}}">
                <div class="invalid-feedback" id="name"></div>
            </div>
        </div>
        <div class="form-row mb-3">
            <div class="col-6">
                <label><i class="fa fa-asterisk text-danger"></i> <strong>E-mail</strong></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-at"></i></span>
                    </div>
                    <input name="email" type="text" class="form-control" value="{{($pre_order) ? $pre_order->email : ''}}">
                    <div class="invalid-feedback" id="email"></div>
                </div>
            </div>
            <div class="col-6">
                <label for="validationCustomUsername"><strong>Номер телефона</strong></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                    </div>
                    <input name="phone" type="text" class="form-control" value="{{($pre_order) ? $pre_order->phone : ''}}">
                    <div class="invalid-feedback" id="phone"></div>
                </div>
            </div>
        </div>
        <div class="special-field col-md-12">
            <label for="subject">Subject</label>
            <input type="text" name="subject" id="subject" value="" />
        </div>
        <div class="form-row mb-3">
            <div class="col-12">
                <label><i class="fa fa-asterisk text-danger"></i> <strong>Ваш заказ. </strong> В этом поле укажите сорт, черенок/саженец и количество.</label>
                <textarea name="message" class="form-control" rows="8">{{($pre_order) ? $pre_order->message : ''}}</textarea>
                <div class="invalid-feedback" id="message"></div>
            </div>
        </div>
        <div class="form-row">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <button class="btn btn-primary" type="submit" id="pre-order" data-url="{{route('vinograd.ajax.pre-order')}}">Отправить</button>
    </div>
{!! Form::close() !!}
