<table class="table table-stripped table-condensed">
    <thead>
        <th width="35%">Name</th>
        <th>Unit (Days)</th>
        <th>Price</th>
        <th>Total (Kshs)</th>
    </thead>
    <tbody>
        @foreach($procedures['doctor'] as $procedure)
            <tr>
                <td width="35%">{{ $procedure['name'] }}</td>
                <td>{{ $procedure['units'] }}</td>
                <td>{{ $procedure['cost'] }}</td>
                <td>{{ $procedure['price'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>