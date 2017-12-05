<div class="panel panel-info">
    <div class="panel-heading">
        Admission Charges
    </div>
    <div class="panel-body">
        <table class="table table-stripped table-condensed">
            <thead>
                <th>Name</th>
                <th>Units</th>
                <th>Price (Kshs)</th>
                <th>Total (Kshs)</th>
            </thead>
            <tbody>
                @foreach($charges as $charge)
                    <tr>
                        <td>{{ $charge['name'] }}</td>
                        <td>1</td>
                        <td>{{ $charge['price'] }}</td>
                        <td>{{ $charge['price'] }}</td>
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