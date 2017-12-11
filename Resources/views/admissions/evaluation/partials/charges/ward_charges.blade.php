<div class="panel panel-info">
    <div class="panel-heading">
        Ward Charges <b class="pull-right">TOTAL: Kshs {{ $wards['price'] }}</b>
    </div>
    <div class="panel-body">
        <table class="table table-stripped table-condensed">
            <thead>
                <th width="35%">Name</th>
                <th>Unit (Days)</th>
                <th>Price</th>
                <th>Total (Kshs)</th>
            </thead>
            <tbody>
                <tr>
                    <td width="35%">{{ $wards['name'] }}</td>
                    <td>{{ $wards['days'] }}</td>
                    <td>{{ $wards['cost'] }}</td>
                    <td>{{ $wards['price'] }}</td>
                </tr>
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