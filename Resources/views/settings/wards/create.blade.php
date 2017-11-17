@extends('layouts.app')
@section('content_title','Add Hospital Ward')
@section('content_description','Adding more wards')

@section('content')

    @include('Inpatient::includes.success')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Add/Edit category</h3>
        </div>
        
        
    </div>

@endsection

