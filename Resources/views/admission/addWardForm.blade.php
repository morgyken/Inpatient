<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */
?>

@extends('layouts.app')
@section('content_title','Products')
@section('content_description','Manage products')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">
            <a href="{{route('inventory.add_product')}}" class="btn btn-sm btn-primary">
                <i class="fa fa-plus-circle"></i> Add Product</a></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if(!$data['products']->isEmpty())
                <table class="table table-responsive table-striped">
                    <tbody>
                        @foreach($data['products'] as $product)
                        <tr id="category{{$product->id}}">
                            <td>{{$product->product_code}}</td>
                            <td>{{$product->name}}{{$product->strength?'('.$product->strength.$product->units->name.')':''}}</td>
                            <td>{{$product->categories?$product->categories->name:'-'}}</td>
                            <td>{{$product->strength?$product->strength.$product->units->name:'-'}}</td>
                            <td>{{$product->reorder_level?$product->reorder_level:'-'}}</td>
                            <td>
                                <a href="{{route('inventory.add_product',$product->id)}}"
                                   class="btn btn-primary btn-xs">
                                    <i class="fa fa-edit"></i> Edit</a> <!--|
                                <button class="btn btn-danger btn-xs delete" value="{{$product->id}}">
                                    <i class="fa fa-trash-o"></i> Delete
                                </button>-->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Strength</th>
                            <th>Reorder Level</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                @else
                <div class="alert alert-info">
                    <p>No products</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        try {
            $('table').dataTable();
        } catch (e) {
        }
    });
</script>
@endsection