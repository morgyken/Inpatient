<div role="tabpanel" id="temp" class="tab-pane fade col-lg-12">
    <center>
        <br/>
        <div class="row">
            <div class="charts" style="background: inherit;">
                <div data-duration="500" class="charts-loader enabled"
                     style="display: none; position: relative; top: -30px; height: 0;">
                    <center>
                        <div class="loading-spinner"
                             style="border: 3px solid #000000; border-right-color: transparent;"></div>
                    </center>
                </div>
                <div class="charts-chart">
                    <div id="temp_chart" style=""></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-inline">
                {{Form::open(['url'=>'api/inpatient/v1/saver/temperature','id'=>'tempForm'])}}
                <div class="form-group">
                    <p>New recordings</p>
                    {{Form::hidden('patient_id',$patient->id)}}
                    {{Form::hidden('admission_id',$admission->id)}}
                    {{Form::text('respiration',null,['class'=>'form-control','placeholder'=>'Respiration'])}}
                    {{Form::text('pulse',null,['class'=>'form-control','placeholder'=>'Pulse'])}}
                    {{Form::text('temperature',null,['class'=>'form-control','placeholder'=>'Temperature','id'=>'temp_tf'])}}
                    {{Form::text('bowels',null,['class'=>'form-control','placeholder'=>'Bowels'])}}
                    {{Form::text('urine',null,['class'=>'form-control','placeholder'=>'Urine'])}}
                    <button type="button" class="btn btn-success" id="tempSave"> Add</button>
                </div>
                {{Form::close()}}
            </div>
        </div>

    </center>
    {!! $tempChart->script() !!}
    <script>
        $(function () {
            $('#tempSave').click(function () {
                $form = $(this).closest('form');
                var my_temp_chart = $("#temp_chart").highcharts();
                $.ajax({type: 'POST', url: $form.attr('action'), data: $form.serialize()})
                    .done(function () {
                            alertify.success('Temperature Recorderd');
                            var series = my_temp_chart.series[0],
                                shift = series.data.length > 20;
                            var the_field = parseInt($('#temp_tf').val());
                            console.log(the_field);
                            my_temp_chart.series[0].addPoint(the_field, true, shift);
                        $('#tempForm').find("input[type=text], textarea").val("");
                        }
                    );
            });
            $('#tempForm').find("input[type=text], textarea").val("");
        });
    </script>
</div>