<div class="panel panel-info">
    <div class="panel-heading">
        Admission Charges <b class="pull-right">TOTAL: Kshs {{ $charges['total'] }}</b>
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
                @foreach($charges as $charge)
                    <tr>
                        <td width="35%">{{ $charge['name'] }}</td>
                        <td>{{ $charge['units'] }}</td>
                        <td>{{ $charge['cost'] }}</td>
                        <td>{{ $charge['total'] }}</td>
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