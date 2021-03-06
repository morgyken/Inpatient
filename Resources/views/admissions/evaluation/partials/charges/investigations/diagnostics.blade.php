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
    @foreach($investigations['diagnostics'] as $investigation)
        <tr>
            <td width="35%">{{ $investigation['name'] }}</td>
            <td>{{ $investigation['units'] }}</td>
            <td>{{ $investigation['cost'] }}</td>
            <td>{{ $investigation['price'] }}</td>
            <td>{!! $investigation['payment_label'] !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>