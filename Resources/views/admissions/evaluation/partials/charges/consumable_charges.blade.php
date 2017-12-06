<div class="panel panel-info">
    <div class="panel-heading">
        Consumable Charges <b class="pull-right">TOTAL: Kshs {{ $consumables['total'] }}</b>
    </div>
    <div class="panel-body">
        <table class="table table-stripped table-condensed">
            <thead>
                <th width="35%">Name</th>
                <th>Units</th>
                <th>Price (Kshs)</th>
                <th>Total (Kshs)</th>
            </thead>
            <tbody>
                @foreach($consumables as $consumable)
                    <tr>
                        <td width="35%">{{ $consumable['name'] }}</td>
                        <td>{{ $consumable['units'] }}</td>
                        <td>{{ $consumable['cost'] }}</td>
                        <td>{{ $consumable['price'] }}</td>
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