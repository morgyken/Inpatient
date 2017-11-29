@include('Inpatient::includes.success')

<div class="panel panel-info" id="form">
    <div class="panel-heading">
        <i class="fa fa-user"></i> {{ $patient->full_name }} | 
        {{ $patient->dob->age }} yr old, {{ $patient->sex }}

        <b class="pull-right">
            <i class="fa fa-h-square"></i> {{ $admission->ward->name }} | 
            <i class="fa fa-bed"></i> {{ $admission->bed->number }}
        </b>
    </div>
    <div class="panel-body">
        {!! Form::open(['url'=>'inpatient/visit/'.$visit->id.'/dispense-drugs']) !!} 
        <div class="row" style="font-weight: bold; border-bottom: 1px solid #ddd; padding-bottom: 15px;">
            <div class="col-md-12">
                <div class="col-md-1">#</div>
                <div class="col-md-2">Drug</div>
                <div class="col-md-4">Prescription</div>
                <div class="col-md-1">Prescribed</div>
                <div class="col-md-1">Dispensed</div>
                <div class="col-md-1">Price</div>
                <div class="col-md-1">Quantity</div>
                <div class="col-md-1">Total</div>
            </div>
        </div>

        @forelse($prescriptions['ordered'] as $prescription)
            {!! Form::hidden("prescriptions[".$prescription['drug']."][id]", $prescription['id']) !!}

            {!! Form::hidden("prescriptions[".$prescription['drug']."][product]", $prescription['drug_id']) !!}

            {!! Form::hidden("prescriptions[".$prescription['drug']."][price]", $prescription['price']) !!}

            {!! Form::hidden("prescriptions[".$prescription['drug']."][total]", $prescription['total']) !!}

            {!! Form::hidden("prescriptions[".$prescription['drug']."][stopped]", $prescription['stopped']) !!}

            <div class="row {{ $prescription['can_dispense'] ? '' : 'strikethrough' }}" 
                style="padding-top: 15px; padding-bottom: 5px; border-bottom: 1px solid #ddd;">
                <div class="col-md-12">
                    <div class="col-md-1">#</div>
                    <div class="col-md-2">
                        <span class="name">{{ $prescription['drug'] }}</span> <br />

                        @if($prescription['stopped'] == 'stopped')
                            <small class="text-danger">Prescription Cancelled</small>
                        @else
                            <small class="text-success">Available in stock - {{ $prescription['stock'] }}</small>
                        @endif    
                    </div>
                    <div class="col-md-4">
                        {{ $prescription['dose'] }}
                    </div>
                    <div class="col-md-1">
                        {{ $prescription['prescribed'] }}
                    </div>
                    <div class="col-md-1">
                        {{ $prescription['dispensed'] }}
                    </div>
                    <div class="col-md-1">
                        {{ $prescription['price'] }}
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="number" name="prescriptions[{{$prescription['drug']}}][quantity]" 
                                class="form-control" value="{{ $prescription['to_dispense'] }}" 
                                {{ $prescription['stopped'] == 'active' ?: 'disabled' }}/>
                        </div>
                    </div>
                    <div class="col-md-1">
                        {{ $prescription['total']  }}
                    </div>
                </div>
            </div>
        @empty
            <p>There are no drugs to sispense</p>
        @endforelse  

        <div style="margin-top: 10px;">
            {!! Form::submit('Dispense Drugs', ['class'=>'btn btn-primary btn-small'])!!}
        </div>

    {!! Form::close()!!}
    </div>

    <style>
        .strikethrough .name{
            text-decoration: line-through;
        }
    </style>
</div>