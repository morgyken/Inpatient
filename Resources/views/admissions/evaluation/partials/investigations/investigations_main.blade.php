<div class="panel panel-info" id="investigationTab">
    <div class="panel-heading">
        <h5>Investigations</h5>
    </div>

    <div class="panel-body">
        <div class="accordion">
            @if(!m_setting('evaluation.no_diagnostics'))
                <h4>Diagnosis</h4>
                <div class="investigation_item">
                    @include('evaluation::partials.doctor.investigations-diagnostics')
                </div>
            @endif

            @if(!m_setting('evaluation.no_laboratory'))
                <h4>Laboratory</h4>
                <div class="investigation_item">
                    @include('evaluation::partials.doctor.investigations-laboratory')
                </div>
            @endif
            @if(!m_setting('evaluation.no_radiology'))
                <h4>Radiology</h4>
                <div class="investigation_item">
                    @include('evaluation::partials.doctor.radiology')
                </div>
            @endif
        </div>
    </div>
</div>    