<div role="tabpanel" id="bp" class="tab-pane fade col-lg-12">
    <center>
        <div class="row">
            <br/>
            <div class="form-inline">
                {{Form::open(['url'=>'api/inpatient/v1/saver/blood_pressure','id'=>'bpForm'])}}
                <div class="form-group">
                    <label class=" control-label">Blood Pressure Recording</label>
                    {{Form::hidden('patient_id',$patient->id)}}
                    {{Form::hidden('admission_id',$admission->id)}}
                    {{Form::text('value',null,['class'=>'form-control','placeholder'=>'Blood pressure'])}}
                    {{Form::text('diastolic',null,['class'=>'form-control','placeholder'=>'Diastolic'])}}
                    <button type="button" class="btn btn-success" id="adder"> Add</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
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
                    <div id="bp_chart" style=""></div>
                </div>
            </div>
        </div>
    </center>
    {!! Charts::scripts() !!}
    {!! $bpChart->script() !!}
    {!! Charts::styles() !!}
    <script>
        $(function () {
            // Javascript to enable link to tab
            var url = document.location.toString();
            if (url.match('#')) {
                $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
            }
            $('.nav-tabs a').on('shown.bs.tab', function (e) {
                window.location.hash = e.target.hash;
            })
            var my_bp_chart = $("#bp_chart").highcharts();
            $('#adder').click(function () {
                $form = $(this).closest('form');
                $.ajax({type: 'POST', url: $form.attr('action'), data: $form.serialize()})
                    .done(function () {
                            alertify.success('Blood pressure Recorderd');
                            var series = my_bp_chart.series[0],
                                shift = series.data.length > 20;
                            var the_field = parseInt($('input[name=value]').val());
                            var the_nfield = parseInt($('input[name=diastolic]').val());
                            var date = new Date().toISOString().slice(0, 19).replace('T', ' ');
                            my_bp_chart.series[0].addPoint(the_field, true, shift);
                            my_bp_chart.series[1].addPoint(the_nfield, true, shift);
                            $('#bpForm').find("input[type=text], textarea").val("");
                        }
                    );
            });
            $('#bpForm').find("input[type=text], textarea").val("");
        });
    </script>
</div>