<div class="panel panel-info" id="consumableTab">
    <div class="panel-heading">
        <h5>Consumables</h5>
    </div>
    <div class="panel-body consumable_item">
        @if(count($consumables) == 0)
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> There are no consumable products. Please add some in inventory.
            </div>
        @else
            {!! Form::open(['id'=>'consumable_form', 'url'=>''])!!}
                {!! Form::hidden('visit', $visit->id) !!}

                {!! Form::hidden('user', Auth::user()->id) !!}

                <div class="row" style="margin-bottom: 10px; border-bottom: 2px solid #ddd; padding-bottom: 12px;">
                    <div class="col-md-12" style="font-weight: bold;">
                        <div class="col-md-1"><i class="fa fa-dor-circle-0"></i></div>
                        <div class="col-md-3">Consumable</div>
                        <div class="col-md-2">Price</div>
                        <div class="col-md-2">Number</div>
                        <div class="col-md-2">Discount</div>
                        <div class="col-md-2">Amount</div>
                    </div>
                </div>

                @foreach($consumables as $consumable)
                    <div id="row{{$consumable->id}}" class="row" style="margin: 15px -15px;">
                        <div class="col-md-12">
                            <div class="col-md-1">
                                @if($consumable->stocks && $consumable->stocks->quantity > 0)
                                    <input type="checkbox" name="item{{$consumable->id}}" value="{{$consumable->id}}" class="check"/>
                                @else
                                    <p>N/A</p>
                                @endif
                            </div>

                            <div class="col-md-3">
                                <span id="name{{$consumable->id}}"> {{$consumable->name}}</span>
                                <br/>
                                <p style="font-style: italic">
                                    Items in stock - {{ $consumable->stocks ? $consumable->stocks->quantity : 0 }}
                                </p> 
                                <input type="hidden" name="type{{$consumable->id}}" value="inpatient_consumable" />
                            </div>

                            <div class="col-md-2">
                                <input type="text" name="price{{$consumable->id}}" value="{{$consumable->selling_p}}" id="cost{{$consumable->id}}"
                                    size="5" readonly/>
                            </div>

                            <div class="col-md-2">
                                <input class="quantity" size="5" value="1" id="quantity{{$consumable->id}}" type="text"
                                    name="quantity{{$consumable->id}}"/>
                            </div>

                            <div class="col-md-2">
                                <input style="color:red" class="discount" size="5" value="0" id="discount{{$consumable->id}}"
                                    type="text" name="discount{{$consumable->id}}" readonly=""/>
                            </div>

                            <div class="col-md-2">
                                <input size="5" id="amount{{$consumable->id}}" type="text" name="amount{{$consumable->id}}"
                                    value="{{$consumable->selling_p}}"/>
                            </div>
                        </div>    
                    </div>
                @endforeach
            {!! Form::close()!!}
        @endif
    </div>
</div>