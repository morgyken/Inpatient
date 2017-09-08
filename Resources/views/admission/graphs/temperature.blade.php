<div id="temperature" class="tab-pane fade col-lg-12">
    <center>
        <br/>
        <div class="row">
            <div class="chart">
                {!! $tempChart->html() !!}
            </div>
        </div>
        <div class="row">
            <div class="form-inline">
                {{Form::open(['url'=>'api/inpatient/v1/saver/temperature'])}}
                <div class="form-group">
                    <p>New recordings</p>
                    {{Form::hidden('patient_id',$patient->id)}}
                    {{Form::hidden('admission_id',$admission->id)}}
                    {{Form::text('respiration',null,['class'=>'form-control','placeholder'=>'Respiration'])}}
                    {{Form::text('pulse',null,['class'=>'form-control','placeholder'=>'Pulse'])}}
                    {{Form::text('temperature',null,['class'=>'form-control','placeholder'=>'Temperature'])}}
                    {{Form::text('bowels',null,['class'=>'form-control','placeholder'=>'Bowels'])}}
                    {{Form::text('urine',null,['class'=>'form-control','placeholder'=>'Urine'])}}
                    <button type="button" class="btn btn-success" id="tempSave"> Add</button>
                </div>
                {{Form::close()}}
            </div>
        </div>

    </center>
</div>
{!! $tempChart->script() !!}
<script>
    $(function () {
        $('#tempSave').click(function () {
            $form = $(this).closest('form');
            $.ajax({type: 'POST', url: $form.attr('action'), data: $form.serialize()})
                .done(function () {
                        alertify.success('Recorderd')
//                        $('input[name=value]').val(0);
                        location.reload();
                    }
                );
        });
    });
</script>