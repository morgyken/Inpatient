<div class="panel panel-info">
    <div class="panel-heading">
        Prescription Charges <b class="pull-right">TOTAL: Kshs {{ $prescriptions['total'] }}</b>
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
                @foreach($prescriptions as $prescription)
                    <tr>
                        <td width="35%">{{ $prescription['name'] }}</td>
                        <td>{{ $prescription['units'] }}</td>
                        <td>{{ $prescription['cost'] }}</td>
                        <td>{{ $prescription['price'] }}</td>
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