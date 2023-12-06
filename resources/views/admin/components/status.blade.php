@if(session('status'))
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="alert alert-info">
                    {!! session('status') !!}
                </div>
            </div>
        </div>
    </div>
@endif
