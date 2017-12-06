<div class="panel panel-info">
    <div class="panel-heading">
        Ward Charges
    </div>
    <div class="panel-body">
        <table class="table table-stripped table-condensed">
            <thead>
                <th>Name</th>
                <th>Unit (Days)</th>
                <th>Price</th>
                <th>Total (Kshs)</th>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $wards['name'] }}</td>
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