<table class="table table-stripped table-condensed">
    <thead>
    <tr>
        <th width="35%">Name</th>
        <th>Unit (Days)</th>
        <th>Price</th>
        <th>Total (Kshs)</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($procedures['nursing'] as $procedure)
        <tr>
            <td width="35%">{{ $procedure['name'] }}</td>
            <td>{{ $procedure['units'] }}</td>
            <td>{{ $procedure['cost'] }}</td>
            <td>{{ $procedure['price'] }}</td>
            <td>{!!  $procedure['payment_label'] !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>