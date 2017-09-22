@extends('layouts.app')
@section('content_title','Deposit Types')
@section('content_description','Manage deposit types')

@section('content')
    @include('Inpatient::includes.success')

<div class="box box-info">
    <div class="box-body">
        <form action="{{url('/inpatient/accounts/addDepositType')}}" method="post">
            <div class="col-lg-5">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <label for="" class="control-label">Deposit Name</label>
                <input type="text"  required name="name" class="form-control">

                <label for="" class="control-label">Amount</label>
                <input type="number"  required name="cost" class="form-control">
                <br>
                <button class="btn btn-primary" type="submit"> <i class="fa fa-plus"></i> Add Deposit</button>
            </div>
        </form>
    </div>

    <div class="box-body">
        <table id="DepositTable" class="table table-stripped condensed">
            <thead>
                <th>Deposit Name</th>
                <th>Amount</th>
                <th>Created On</th>
                <th>Actions</th>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>

    <div class="modal fade"  id="editDepositModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Deposit</h4>
                    </div>
                    <form action="{{url('/inpatient/accounts/deposits/edit')}}" method="post" id = "update_deposit_form">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <input type="hidden" name="deposit_id" id="deposit_id">
                            <label for="" class="control-label">Deposit:</label>
                            <input type="text" name="deposit" id="deposit" class="form-control" required>

                            <label for="" class="control-label">Amount:</label>
                            <input type="text" name="cost" id="amount" class="form-control" required>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="update_deposit"><i class='fa fa-save'></i> Update</button>
                            <button class="btn btn-default" data-dismiss="modal"><i class='fa fa-times'></i> Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
    <script>
        $(function () {
            $("#DepositTable").dataTable({
                ajax: "{{ url('/inpatient/accounts/deposits/all') }}",
                responsive:true
            });

            $("body").on("click", ".delete", function () {
                vl = this.value;
                $("#deposit_id").value= vl;
                url = '{{url('/inpatient/accounts/edit_deposit')}}'+'/'+vl;
                $.ajax({
                    url:url
                }).done(function (data) {
                    $("#deposit").val(data.name);
                    $("#deposit_id").val(data.id);
                    $("#amount").val(data.cost);
                     $('#editDepositModal').modal();
                })
            });

            $("#update_deposit").click(function(e){
                    $(this).html("Saving...");
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: $("#update_deposit_form").attr('action'),
                        data: $("#update_deposit_form").serialize()
                    }).done(function (data) {
                        document.getElementById("update_deposit_form").reset();
                        $(this).html("<i class='fa fa-save'></i> Update Deposit");
                        $("#DepositTable").dataTable().api().ajax.reload();
                        $("#editDepositModal").modal("toggle");
                    })
                });
        })
    </script>

@endsection