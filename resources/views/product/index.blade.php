<!DOCTYPE html>
<html lang="en">
@include('layouts.head')

<body>
    <div class="wrapper">
        @include('layouts.sidebar')
        <div class="main-panel">
            <div class="content">
                <div class="panel-header">
                    <div class="page-inner py-5">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="pb-2 fw-bold">{{ $title }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner mt--5">
                    <!-- Button -->
                    <div class="d-flex">
                        <a class="btn btn-primary btn-round ml-auto mb-3" data-target="#showCreateModal"
                            data-toggle="modal" href="#showCreateModal">
                            <i class="fa fa-plus"></i>
                            Tambah Produk
                        </a>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <div id="add-row_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="dataTables_length" id="add-row_length"></div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div id="add-row_filter"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="add-row" class="display table table-striped table-hover dataTable"
                                        cellspacing="0" width="100%" role="grid" aria-describedby="add-row_info"
                                        style="width: 100%;">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" width="10%">
                                                    <center>No</center>
                                                </th>
                                                <th width="30%">
                                                    <center>Produk</center>
                                                </th>
                                                <th width="25%">
                                                    <center>Harga</center>
                                                </th>
                                                <th>
                                                    <center>Status</center>
                                                </th>
                                                <th width="10%">
                                                    <center>Aksi</center>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $key => $prod)
                                                <tr role="row" class="odd">
                                                    <td>
                                                        <center>{{ $key + 1 }}</center>
                                                    </td>
                                                    <td class="sorting_1">
                                                        {{ $prod->name }}
                                                    </td>
                                                    <td class="sorting_1" style="text-align:right;">
                                                        Rp. {{ number_format($prod->price, 0, ',', '.') }}
                                                    </td>
                                                    <td class="sorting_1">
                                                        <center>
                                                            @php
                                                                if ($prod->status) {
                                                                    echo '<span class="badge badge-success">Aktif</span>';
                                                                } else {
                                                                    echo '<span class="badge badge-danger">Tidak Aktif</span>';
                                                                }
                                                            @endphp
                                                        </center>
                                                    </td>
                                                    <td>
                                                        <center>
                                                            <div class="form-button-action">
                                                                <a onclick="editData({{ $prod->id }})"
                                                                    data-toggle="tooltip" title="Edit"
                                                                    class="btn btn-link btn-warning btn-icon btn-lg"
                                                                    data-original-title="Edit"
                                                                    control-id="ControlID-16">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <button type="submit"
                                                                    onclick="destroy({{ $prod->id }}, '{{ $prod->name }}')"
                                                                    data-toggle="tooltip" title="Delete"
                                                                    class="btn btn-link btn-danger btn-icon btn-lg"
                                                                    data-original-title="Delete"
                                                                    control-id="ControlID-17">
                                                                    <i class="fa fa-trash" style="color:red;"></i>
                                                                </button>
                                                            </div>
                                                        </center>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="add-row_info"></div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_simple_numbers" id="add-row_paginate">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- modal --}}
            <div class="modal show" id="showCreateModal" tabindex="-1" role="dialog"
                aria-labelledby="showCreateModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLongTitle"><b>Tambah Produk</b></h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.product.store') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Masukkan Nama" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Harga</label>
                                        <div class="d-flex">
                                            <span class="input-group-text bg-default">
                                                Rp.
                                            </span>
                                            <input type="number" style="text-align:right" name="price"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Foto</label>
                                        <input type="file" class="form-control" name="picture" id="picture"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="row p-10" style="float:right;">
                                    <div class="col-md-12 ">
                                        <button type="submit" class="btn btn-sm btn-outline-success mt-2 ml-2">
                                            <i class="fa fa-check"></i>
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal show" id="showEditModal" tabindex="-1" role="dialog"
                aria-labelledby="showEditModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLongTitle"><b>Tambah User</b></h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.product.update') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <input type="hidden" name="id" id="edit_id">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control" name="name" id="edit_name"
                                            placeholder="Masukkan Nama" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Harga</label>
                                        <div class="d-flex">
                                            <span class="input-group-text bg-default">
                                                Rp.
                                            </span>
                                            <input type="number" style="text-align:right" name="edit_price"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Foto</label>
                                        <input type="file" class="form-control" name="picture" id="edit_picture"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="row p-10" style="float:right;">
                                    <div class="col-md-12 ">
                                        <button type="submit" class="btn btn-sm btn-outline-success mt-2 ml-2">
                                            <i class="fa fa-check"></i>
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
            <script src="{{ asset('js/app/table.js') }}"></script>
        </div>
    </div>
</body>
<script>
    function destroy(id, name) {
        var token = $('meta[name="csrf-token"]').attr('content');

        swal({
            title: "",
            text: "Apakah kamu yakin menghapus " + name + " ?",
            icon: "warning",
            buttons: ['Batal', 'Ya'],
            // dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.post("{{ route('admin.product.delete') }}", {
                    id: id,
                    _token: token
                }, function(data) {
                    location.reload();
                })
            } else {
                return false;
            }
        });
    }

    function editData(id) {
        let stock_code_item = $('#stock_code_item').val();
        $.get("{{ url('admin/product/show') }}/" + id).done(function(data) {
            $('#showEditModal').modal('show');
            $('#edit_id').val(data.id);
            $('#edit_name').val(data.name);
            $('#edit_price').val(data.price);
            $('#edit_picture').val(data.picture);
        });
    }
</script>

@include('layouts.swal')

</html>
