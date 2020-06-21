@extends('layouts.dashboard')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Treatment</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Transaction</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>


<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <a href="javascript:void(0)" id="add-data" class="btn btn-outline-primary pull-right" style="margin-top: 8px;">Add Treatment</a>
                    </h4>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="treat-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>User ID</th>
                                <th>Amount</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Harga</th>
                                <th>Jenis Treatment</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


<!---Modal--->
<div class="modal fade" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-treat" method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h3 class="modal-title" id="modaltitle"></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>

                </div>

                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="start_date" class="col-md-3 control-label">Start Date</label>
                        <div class="col-md-6">
                            <input type="date" id="start_date" name="start_date" class="form-control" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="end_date" class="col-md-3 control-label">End Date</label>
                        <div class="col-md-6">
                            <input type="date" id="end_date" name="end_date" class="form-control" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="col-md-3 control-label">Status</label>
                        <div class="col-md-6">
                            <input type="text" id="status" name="status" class="form-control" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="treatment_price_id" class="col-md-3 control-label">Treatment Price ID</label>
                        <div class="col-md-6">
                            <input type="text" id="treatment_price_id" name="treatment_price_id" class="form-control" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="treatment_type_id" class="col-md-3 control-label">Treatment Type ID </label>
                        <div class="col-md-6">
                            <input type="text" id="treatment_type_id" name="treatment_type_id" class="form-control" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="qty" class="col-md-3 control-label">Quantity</label>
                        <div class="col-md-6">
                            <input type="text" id="qty" name="qty" class="form-control" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="saveBtn" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>
<!---EndModal--->

@endsection


@push('script')

<script type="text/javascript">
    const tokenData = JSON.parse(window.localStorage.getItem('authUser'))
    const header = {
        "Accept": "application/json",
        "Authorization": "Bearer " + tokenData.access_token
    }

    $(document).ready(function() {
        $('#treat-table').DataTable({
            proccessing: false,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            ajax: {
                url: "{{route('transact.index')}}",
                type: 'GET',
                headers: header
            },
            order: [
                [1, "asc"]
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'no',
                    orderable: false,
                    width: '3%'
                },
                {
                    data: 'user_id',
                    name: 'user_id',
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'start_date',
                    name: 'start_date',
                },
                {
                    data: 'end_date',
                    name: 'end_date',
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'harga',
                    name: 'harga',
                },
                {
                    data: 'treatment_type_id',
                    name: 'treatment_type_id',
                },
                {
                    data: 'qty',
                    name: 'qty',
                },
                {
                    data: 'price',
                    name: 'price',
                },
                {
                    data: 'total',
                    name: 'total',
                },
                {
                    data: 'action',
                    name: 'action',
                    width: '15%'
                }
            ]
        });
    });

    $('#add-data').click(function() {
        $('#saveBtn').val("Add");
        $('#id').val('');
        $('#form-treat').trigger("reset");
        $('#modaltitle').html("Add New Transaction");
        $('#modal-form').modal('show');
    });

    $(document).on('click', '.edit', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "{{url('api/transact/edit')}}" + "/" + id,
            type: "GET",
            headers: header,
            dataType: "JSON",
            success: function(data) {
                $('#id').val(data.id);
                $('#start_date').val(data.start_date);
                $('#end_date').val(data.end_date);
                $('#status').val(data.status);
                $('#treatment_price_id').val(data.treatment_price_id);
                $('#treatment_type_id').val(data.treatment_type_id);
                $('#qty').val(data.qty);

                $('#modaltitle').html("Edit Transaction");
                $('#saveBtn').val("Edit");
                $('#modal-form').modal('show');
            }
        })
    });

    $(document).ready(function() {

        if ($("#form-treat").length > 0) {
            $("#form-treat").validate({

                submitHandler: function(form) {

                    var actionType = $('#saveBtn').val();
                    $('#saveBtn').html('Saving..');

                    if ($('#saveBtn').val() == 'Add') {
                        url = "{{ route('transact.store') }}";
                        method = "POST";
                    } else {
                        var id = document.getElementById('id').value;
                        url = "{{url('api/transact/update')}}" + "/" + id;
                        method = "PUT";
                    }
                    $.ajax({
                        data: $('#form-treat').serialize(),
                        url: url,
                        type: method,
                        headers: header,
                        dataType: 'json',
                        success: function(data) { //jika berhasil 
                            $('#form-treat').trigger("reset");
                            $('#modal-form').modal('hide');
                            $('#saveBtn').html('Submit');
                            var oTable = $('#treat-table').dataTable();
                            oTable.fnDraw(false); //reset datatable
                            Swal.fire(
                                'Done!',
                                'Data Saved Successfully!',
                                'success')
                        },
                        error: function(data) {
                            console.log('Error:', data);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            })
                        }
                    });

                }
            })
        };
    });

    $(document).on('click', '.delete', function() {
        Swal.fire({
            title: 'Are you sure ?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                var id = $(this).data('id');
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('api/transact/delete') }}" + '/' + id,
                    headers: header,
                    success: function(data) {
                        var oTable = $('#treat-table').dataTable();
                        oTable.fnDraw(false);
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        })
                    }
                });
            } else {
                Swal.fire('Your data is safe');
            }
        });
    });
</script>

@endpush