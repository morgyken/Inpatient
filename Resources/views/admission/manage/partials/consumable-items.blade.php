<?php
$products = get_inventory_consumables();
?>
@if($products->isEmpty())
    <div class="alert alert-info">
        <i class="fa fa-info-circle"></i> There are no consumable products. Please add some in inventory.
    </div>
@else
    {!! Form::open(['id'=>'consumable_form'])!!}
    {!! Form::hidden('visit',$admission->visit_id) !!}
    <table class="table table-condensed table-borderless table-responsive" id="doctor-procedures">
        <tbody>
        @foreach($products as $item)
            <tr id="row{{$item->id}}">
                <td>
                    <input type="checkbox" name="item{{$item->id}}" value="{{$item->id}}" class="check"/>
                </td>
                <td>
                    <span id="name{{$item->id}}"> {{$item->name}}</span>
                    <br/>
                    <input type="hidden" name="type{{$item->id}}" value="inpatient.procedure-doctor" disabled/>
                    <span class="instructions">
                    <textarea placeholder="Instructions" name="instructions{{$item->id}}" disabled
                              cols="50"></textarea></span>
                </td>
                <td>
                    <input type="text" name="price{{$item->id}}" value="{{$item->selling_p}}" id="cost{{$item->id}}"
                           size="5" readonly/>
                </td>
                <td><input style="color:red" class="discount" size="5" value="0" id="discount{{$item->id}}"
                           type="text" name="discount{{$item->id}}" readonly=""/></td>
                <td><input class="quantity" size="5" value="1" id="quantity{{$item->id}}" type="text"
                           name="quantity{{$item->id}}"/></td>
                <td><input size="5" id="amount{{$item->id}}" type="text" name="amount{{$item->id}}"
                           value="{{$item->selling_p}}"/></td>
            </tr>
        @endforeach
        </tbody>
        <thead>
        <tr>
            <th></th>
            <th>Consumable</th>
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