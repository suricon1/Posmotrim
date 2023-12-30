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
    <div class="btn-group btn-group-sm ml-2" role="group" aria-label="Button group with nested dropdown">
        <div class="btn-group btn-group-sm" role="group">
            <button id="btnGroupDrop1" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                . . . .
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                @foreach(yearsQuery()['dropdown'] as $year => $period)
                    <a href="{{route($route, array_merge(request()->query(), ['from' => $period['from'], 'to' => $period['to']]))}}" class="dropdown-item">{{$year}}</a>
                @endforeach
            </div>
        </div>
        @foreach(yearsQuery()['visible'] as $year => $period)
            <a href="{{route($route, array_merge(request()->query(), ['from' => $period['from'], 'to' => $period['to']]))}}"  class="btn btn-outline-secondary">{{$year}}</a>
        @endforeach

    </div>
</div>


