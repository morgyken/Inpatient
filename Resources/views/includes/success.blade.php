@if(\Illuminate\Support\Facades\Session::has('success'))
    <div class="alert alert-success">
        <span>{{\Illuminate\Support\Facades\Session::get('success')}}</span>
    </div>
    @endif

    @if(\Illuminate\Support\Facades\Session::has('error'))
    <div class="alert alert-warning">
        <span>{{\Illuminate\Support\Facades\Session::get('error')}}</span>
    </div>
    @endif
@if(isset($a))
    <div class="alert alert-success">
        <span>{{$success}}</span>
    </div>
    @endif