<div class="panel panel-info">
    <div class="panel-heading">
        Procedures Charges
    </div>
    <div class="panel-body">
        <table class="table table-stripped table-condensed">
            <thead>
                <th>Name</th>
                <th>Units</th>
                <th>Price (Kshs)</th>
                <th>Total (Kshs)</th>
                <th>Dispensed At</th>
            </thead>
            <tbody>
                @foreach($prescriptions as $prescription)
                    <tr>
                        <td>{{ $prescription['name'] }}</td>
                        <td>{{ $prescription['units'] }}</td>
                        <td>{{ $prescription['cost'] }}</td>
                        <td>{{ $prescription['price'] }}</td>
                        <td>{{ $prescription['dispensed'] }}</td>
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