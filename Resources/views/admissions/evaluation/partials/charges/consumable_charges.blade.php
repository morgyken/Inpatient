<div class="panel panel-info">
    <div class="panel-heading">
        Consumable Charges
    </div>
    <div class="panel-body">
        <table class="table table-stripped table-condensed">
            <thead>
                <th>Name</th>
                <th>Units</th>
                <th>Price (Kshs)</th>
                <th>Total (Kshs)</th>
                <th>Used At</th>
            </thead>
            <tbody>
                @foreach($consumables as $consumable)
                    <tr>
                        <td>{{ $consumable['name'] }}</td>
                        <td>{{ $consumable['units'] }}</td>
                        <td>{{ $consumable['cost'] }}</td>
                        <td>{{ $consumable['price'] }}</td>
                        <td>{{ $consumable['used_on'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            
        </div>
    </div>

    <!-- Start Scripts -->
    {{-- @push('scripts') --}}
    <script>
        
    </script>
    {{-- @endpush --}}
</div>