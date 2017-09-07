<div id="bp" class="tab-pane fade col-lg-12">
    <center>
        <div class="row">
            <br/>
            <div class="form-inline">
                {{Form::open(['url'=>'api/inpatient/v1/saver/blood_pressure'])}}
                <div class="form-group">
                    <label class=" control-label">Blood Pressure Recording</label>
                    {{Form::hidden('patient_id',$patient->id)}}
                    {{Form::hidden('admission_id',$admission->id)}}
                    {{Form::text('value',null,['class'=>'form-control'])}}
                    <button type="button" class="btn btn-success" id="adder"> Add</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
        <div class="row">
            <div class="chart">
                {!! $bpChart->html() !!}
            </div>

        </div>
    </center>
</div>
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

// Change hash for page-reload
        $('.nav-tabs a').on('shown.bs.tab', function (e) {
            window.location.hash = e.target.hash;
        })
        $('#adder').click(function () {
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