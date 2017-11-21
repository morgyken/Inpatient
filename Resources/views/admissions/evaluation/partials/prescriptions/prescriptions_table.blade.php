<div class="panel panel-info">
    <div class="panel-heading">
        Prescriptions Table
    </div>
    <div class="panel-body">
        <table class="table table-stripped table-condensed">
            <caption>The Patient List: All The Patients awaiting admission</caption>
            <thead>
                <th>Name</th>
                <th>Date/Time</th>
                <th>Prescribed</th>
                <th>Dispensed</th>
                <th>Remaining</th>
                <th>Actions</th>
            </thead>
            <tbody>
            @foreach($prescriptions as $prescription)
                <tr>
                    <td>{{ $prescription['drug'] }}</td>
                    <td>{{ $prescription['dose'] }}</td>
                    <td>{{ $prescription['prescribed'] }}</td>
                    <td>{{ $prescription['dispensed'] }}</td>
                    <td>{{ $prescription['remaining'] }}</td>
                    <td>
                        <a class="btn btn-success btn-xs" href="#">Administer</a>
                        <a class="btn btn-danger btn-xs" href="#">Cancel</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
            <button class="btn btn-primary col-md-2" data-toggle="modal" data-target="#dispenseModal">Dispense Drugs</button>
        </div>

        <!-- Dispense modal -->

        <div class="modal fade" id="dispenseModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Drugs to be dispensed</h4>
                    </div>
                    <div class="modal-body" style="overflow: hidden;">
                        {!! Form::open(['url' => 'inpatient/admissions/'.$admission->id.'/prescription/dispense', 'class' => 'form-horizontal', 'id' => 'dispense-form']) !!}
                            
                            {!! Form::hidden('visit', $admission->visit->id) !!}

                            {!! Form::hidden('user', Auth::user()->id) !!}
                            
                            @foreach($prescriptions as $prescription)

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="" style="line-height: 30px;">{{ $prescription['drug'] }}</label>
                                        </div>
                                        <div class="col-md-8">
                                            {!! Form::text($prescription['id'], $prescription['to_dispense'], ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                            
                            @endforeach

                        {{ Form::close() }}
                    </div>
                    <div class="modal-footer">
                        <button id="dispense-button" type="button" class="btn btn-primary">Confirm</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- End of Dispense Modal -->

    </div>

    <!-- Start Scripts -->
    {{-- @push('scripts') --}}
    <script>
        $('#dispense-button').click(function(){
            $('#dispense-form').submit();
        })
    </script>
    {{-- @endpush --}}
</div>