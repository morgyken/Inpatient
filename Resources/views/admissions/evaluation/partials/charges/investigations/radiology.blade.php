<table class="table table-stripped table-condensed">
    <thead>
        <th width="35%">Name</th>
        <th>Unit (Days)</th>
        <th>Price</th>
        <th>Total (Kshs)</th>
        <th>Status</th>
    </thead>
    <tbody>
        @foreach($investigations['radiology'] as $investigation)
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