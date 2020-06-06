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
                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Treatment</li>
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
                        <a onclick="addForm()" class="btn btn-primary pull-right" style="margin-top: -8px;">Add Treatment</a>
                    </h4>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="treat-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis Treatment</th>
                                <th>Harga</th>
                                <th>Waktu Pengerjaan</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
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
<div class="modal" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-treat" method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                    <h3 class="modal-title"></h3>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label">Jenis Treatment</label>
                        <div class="col-md-6">
                            <input type="text" id="jenis_treatment" name="jenis_treatment" class="form-control" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label">Harga</label>
                        <div class="col-md-6">
                            <input type="text" id="harga" name="harga" class="form-control" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label">Waktu Pengerjaan</label>
                        <div class="col-md-6">
                            <input type="text" id="waktu_pengerjaan" name="waktu_pengerjaan" class="form-control" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label">Quantity</label>
                        <div class="col-md-6">
                            <input type="text" id="qty" name="qty" class="form-control" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label">Subtotal</label>
                        <div class="col-md-6">
                            <input type="text" id="subtotal" name="subtotal" class="form-control" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-save">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection


@push('script')

<script type="text/javascript">
    $(document).ready(function() {
        $('#treat-table').DataTable({
            proccessing: true,
            serverSide: true,
            ajax: {
                url: "{{route('treatment.index')}}",
                type: 'GET',
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'jenis_treatment',
                    name: 'jenis_treatment'
                },
                {
                    data: 'harga',
                    name: 'harga'
                },
                {
                    data: 'waktu_pengerjaan',
                    name: 'waktu_pengerjaan'
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
                {
                    data: 'subtotal',
                    name: 'subtotal'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
    });
</script>

@endpush