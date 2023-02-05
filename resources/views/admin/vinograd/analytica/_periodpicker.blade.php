<div class="btn-toolbar mt-1">
    <div class="input-group">
        <form action="?" method="GET">
            <div class="input-group input-group-sm">
                <input name="from" id="periodpickerstart" type="text" />
                <input name="to" id="periodpickerend" type="text" />
                @if(request('status'))
                    <input name="status" type="hidden" value="{{request('status')}}" />
                @endif
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Показать</button>
                </div>
            </div>
        </form>
    </div>
    <div class="btn-group ml-2 btn-group-sm">
        @foreach(yearsQuery() as $year => $period)
        <a href="{{route($route, array_merge(request()->query(), ['from' => $period['from'], 'to' => $period['to']]))}}"  class="btn btn-outline-secondary">{{$year}}</a>
        @endforeach
    </div>
</div>
