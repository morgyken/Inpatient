<div class="panel panel-info">
    <div class="panel-heading">
        General Admission Charges
    </div>
    <div class="panel-body">
        <table class="table table-stripped table-condensed">
            <thead>
                <th>Name</th>
                <th>Unit (Days)</th>
                <th>Pice</th>
                <th>Total (Kshs)</th>
            </thead>
            <tbody>
            @foreach($charges['general'] as $charge)
                <tr>
                    <td>{{ $charge['name'] }}</td>
                    <td>{{ $charge['units'] }}</td>
                    <td>{{ $charge['price'] }}</td>
                    <td>{{ $charge['total'] }}</td>
                </tr>
            @endforeach
                <tr>
                    <td colspan="3"><b>Total</b></td>
                    <td>{{ $charges['generalTotal'] }}</td>
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