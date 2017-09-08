<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 *///$diagnosis=

$labs = get_procedures_for('laboratory');
$discount_allowed = json_decode(m_setting('evaluation.discount'));

$co = null;
$visit = \Ignite\Evaluation\Entities\Visit::find($admission->visit_id);
if ($visit->payment_mode == 'insurance') {
    $co = $visit->patient_scheme->schemes->companies->id;
}
?>
@if($labs->isEmpty())
<div class="alert alert-info">
    <i class="fa fa-info-circle"></i> There are no procedures. Please go to setup and add some.
</div>
@else
{!! Form::open(['id'=>'laboratory_form'])!!}
{!! Form::hidden('visit',$admission->visit_id) !!}
<table class="table table-condensed table-borderless table-responsive" id="procedures">
    <tbody>
        @foreach($labs as $procedure)
        <?php
        $c_price = \Ignite\Settings\Entities\CompanyPrice::whereCompany(intval($co))
                ->whereProcedure(intval($procedure->id))
                ->get()
                ->first();
        if (isset($c_price)) {
            if ($c_price->price > 0) {
                $price = $c_price->price;
            }
        } else {
            $price = $procedure->price;
        }
        ?>
        <tr id="row{{$procedure->id}}">
            <td>
                <input type="checkbox" name="item{{$procedure->id}}" value="{{$procedure->id}}" class="check"/>
            </td>
            <td>
                <span id="name{{$procedure->id}}"> {{$procedure->name}}</span><br/>
                <span class="instructions">
                    <textarea placeholder="Instructions" name="instructions{{$procedure->id}}" disabled cols="50">
                    </textarea>
                    <!--
                    @if(!$procedure->items->isEmpty())
                    <hr>
                    <h5>Inventory Item(s) Consumed</h5>
                    <table class="table">
                        <tr>
                            <th>Item</th>
                            <th>Units Consumed</th>
                        </tr>
                        @foreach($procedure->items as $item)
                        <tr>
                            <td>{{$item->inventory->name}}</td>
                            <td><input type="text" name="units" class="form-control" ></td>
                        </tr>
                        @endforeach
                    </table>
                    @endif
                    -->
                </span>
                <input type="hidden" name="type{{$procedure->id}}" value="laboratory" disabled />
            </td>
            <td>
                <input type="text" name="price{{$procedure->id}}" value="{{$price}}" id="cost{{$procedure->id}}" size="5" readonly=""/>
            </td>
            <td><input class="quantity" size="5" value="1" id="quantity{{$procedure->id}}" type="text" name="quantity{{$procedure->id}}"/></td>
            <td>
                @if(is_array($discount_allowed) &&  in_array('laboratory', $discount_allowed))
                <input class="discount" size="5" value="0" id="discount{{$procedure->id}}" type="text" name="discount{{$procedure->id}}"/>
                @else
                <input style="color:red" class="discount" size="5" value="0" id="discount{{$procedure->id}}" type="text" name="discount{{$procedure->id}}" readonly=""/>
                @endif
            </td>
            <td><input size="5" id="amount{{$procedure->id}}" type="text" name="amount{{$procedure->id}}"/></td>
        </tr>
        @endforeach
    </tbody>
    <thead>
        <tr>
            <th></th>
            <th>Test</th>
            <th>Price</th>
            <th>Number Performed</th>
            <th>Discount</th>
            <th>Amount</th>
            <th></th>
        </tr>
    </thead>
</table>
{!! Form::close()!!}
@endif