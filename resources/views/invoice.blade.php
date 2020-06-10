@extends('layouts.dashboard')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Invoice</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Invoice</li>
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
                        <a href="javascript:void(0)" id="add-data" class="btn btn-outline-primary pull-right" style="margin-top: 8px;">Add Invoice</a>
                    </h4>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="invoice_table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nama Customer</th>
                                <th>Jenis Treatment</th>
                                <th>Waktu Masuk</th>
                                <th>Total</th>
                                <th>Status</th>
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


<!---addModal--->
<div class="modal fade" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-invoice" method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
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
                        <label for="name" class="col-md-3 control-label">Nama Customer</label>
                        <div class="col-md-6">
                            <input type="text" id="nama" name="nama" class="form-control" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label">Jenis Treatment</label>
                        <div class="col-md-6">
                            <input type="text" id="jenis_treatment" name="jenis_treatment" class="form-control" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label">Waktu Masuk</label>
                        <div class="col-md-6">
                            <input type="text" id="waktu_masuk" name="waktu_masuk" class="form-control" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label">Status</label>
                        <div class="col-md-6">
                            <input type="text" id="status" name="status" class="form-control" autofocus required>
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
        $('#invoice_table').DataTable({
            proccessing: true,
            serverSide: true,
            ajax: {
                url: "{{route('invoice.index')}}",
                type: 'GET',
                headers: header
            },
            columns: [{
                    data: 'user_id',
                    name: 'user_id'
                },
                {
                    data: 'treatment_id',
                    name: 'treatment_id'
                },
                {
                    data: 'waktu_masuk',
                    name: 'waktu_masuk'
                },
                {
                    data: 'total',
                    name: 'total'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
    });

    $('#add-data').click(function() {
        $('#saveBtn').val("Add");
        $('#id').val('');
        $('#form-invoice').trigger("reset");
        $('#modaltitle').html("Add New Invoice");
        $('#modal-form').modal('show');
    });

    $('body').on('click', '.edit', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "{{url('api/invoice/edit')}}" + "/" + id,
            type: "GET",
            headers: header,
            dataType: "JSON",
            success: function(data) {
                $('#user_id').val(data.user_id);
                $('#treatment_id').val(data.treatment_id);
                $('#waktu_masuk').val(data.waktu_masuk);
                $('#status').val(data.status);

                $('#modaltitle').html("Edit Invoice");
                $('#saveBtn').val("Edit");
                $('#modal-form').modal('show');
            }
        })
    });

    if ($("#form-invoice").length > 0) {
        var id = $(this).attr('id');
        $("#form-invoice").validate({

            submitHandler: function(form) {

                var actionType = $('#saveBtn').val();
                $('#saveBtn').html('Saving..');


                if ($('#saveBtn').val() == 'Add') {
                    url = "{{ route('inovice.store') }}";
                } else {
                    url = "{{url('api/inovice/update')}}" + "/" + id;
                }

                $.ajax({
                    data: $('#form-invoice').serialize(),
                    url: url,
                    type: "POST",
                    headers: header,
                    dataType: 'json',
                    success: function(data) { //jika berhasil 
                        $('#form-invoice').trigger("reset");
                        $('#modal-form').modal('hide');
                        $('#saveBtn').html('Submit');
                        var oTable = $('#invoice_table').dataTable();
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
    }

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
                    url: "{{ url('api/invoice/delete') }}" + '/' + id,
                    headers: header,
                    success: function(data) {
                        var oTable = $('#invoice_table').dataTable();
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