<table class="table mb-0">
    <tbody>
    @foreach($compares as $items)
        <tr>
            @foreach($items as $item)
                @if ($loop->first)
                    <th scope="row">{!! $item !!}</th>
                @else
                    <td>{!! $item !!}</td>
                @endif
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
