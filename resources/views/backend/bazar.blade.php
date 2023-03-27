@extends('Layouts.Base')

@section('content')
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Bazar</h6>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#BazarModal" id="#myBtn">
                    Tambah Data
                </button>
            </div>
            <div class="p-3">
                <div class="row" id="data-container">
                    <div class="table-responsive p-3">
                        <table id="dataTable" class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Menu</th>
                                    <th>Harga</th>
                                    <th>Gambar</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data from database will be shown here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal create data-->
    <div class="modal fade" id="BazarModal" tabindex="-1" role="dialog" aria-labelledby="BazarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="BazarModalLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formTambah" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama_menu">Nama Menu</label>
                            <input type="text" class="form-control" name="nama_menu" id="nnama_menu"
                                placeholder="Input Here..">
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control" name="harga" id="harga"
                                placeholder="Input Here">
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <input type="file" class="form-control" name="gambar" id="gambar">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" name="description" id="description"
                                placeholder="Input Here">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary">Create Data</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal edit-->
    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEdit" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="nama_menu">Nama Menu</label>
                            <input type="text" class="form-control" name="nama_menu" id="enama_menu"
                                placeholder="Input Here..">
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control" name="harga" id="eharga"
                                placeholder="Input Here">
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <input type="file" class="form-control" name="gambar" id="egambar">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" name="description" id="edescription"
                                placeholder="Input Here">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary">Update Data</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        //get data
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('getData.bazar') }}",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    var tableBody = "";
                    $.each(response.data, function(index, item) {
                        tableBody += "<tr>";
                        tableBody += "<td>" + (index + 1) + "</td>";
                        tableBody += "<td>" + item.nama_menu + "</td>";
                        tableBody += "<td>Rp. " + item.harga + "</td>";
                        tableBody += "<td><img src='/uploads/menu/" + item.gambar + "' alt='" +
                            item.nama_menu +
                            "' class='img-thumbnail' style='width: 200px'></td>";
                        tableBody += "<td>" + item.description + "</td>";
                        tableBody += "<td>" +
                            "<button type='button' class='btn btn-primary edit-modal' data-toggle='modal' data-target='#EditModal' " +
                            "data-id='" + item.id + "' " +
                            "<i class='fa fa-edit'>Edit</i></button>" +
                            "<button type='button' class='btn btn-danger delete-confirm' data-id='" +
                            item.id + "'><i class='fa fa-trash'></i></button>" +
                            "</td>";

                        tableBody += "</tr>";
                    });
                    $('#dataTable').DataTable().destroy();
                    $("#dataTable tbody").empty();
                    $("#dataTable tbody").append(tableBody);
                    $('#dataTable').DataTable({
                        "paging": true,
                        "ordering": true,
                        "searching": true
                    });
                },
                error: function() {
                    console.log("Failed to get data from server");
                }
            });
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //tambah data
        $(document).ready(function() {
            // Mengambil form tambah data
            var formTambah = $('#formTambah');

            formTambah.on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('tambahData.bazar') }}",
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log(data);
                        Swal.fire({
                            title: "Success",
                            text: "Data berhasil ditambahkan",
                            icon: "success",
                            showCancelButton: false,
                            confirmButtonText: "OK"
                        }).then(function() {
                            location.reload();
                        });
                    },
                    error: function(data) {
                        var errors = data.responseJSON.errors;
                        var errorMessage = "";

                        $.each(errors, function(key, value) {
                            errorMessage += value + "<br>";
                        });

                        Swal.fire({
                            title: "Error",
                            html: errorMessage,
                            icon: "error",
                            timer: 5000,
                            showConfirmButton: true
                        });
                    }
                });
            });
        });

        // //edit

        // $(document).on('click', '.edit-modal', function() {
        //     $('#id').val($(this).data('id'));
        //     $('#nama_menu').val($(this).data('nama_menu'));
        //     $('#harga').val($(this).data('harga'));
        //     $('#gambar').val($(this).data('gambar'));
        //     $('#description').val($(this).data('description'));
        //     $('#EditModal').val($(this).data('show'));
        // })


        // $(document).on('click', '.delete-confirm', function(event) {
        //     event.preventDefault();
        //     var id = $(this).data('id');
        //     var row = $(this).closest('tr');

        //     Swal.fire({
        //         title: 'Apakah Anda yakin ingin menghapus data ini?',
        //         text: "Data yang sudah dihapus tidak dapat dikembalikan!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#d33',
        //         cancelButtonColor: '#3085d6',
        //         confirmButtonText: 'Ya, hapus!',
        //         cancelButtonText: 'Batal'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 url: "{{ url('bazar/delete/') }}/" + id,
        //                 method: "DELETE",
        //                 data: {
        //                     _token: '{{ csrf_token() }}'
        //                 },
        //                 dataType: "json",
        //                 success: function(response) {
        //                     console.log(response);
        //                     if (response.success) {
        //                         row.remove();
        //                         Swal.fire(
        //                             'Terhapus!',
        //                             'Data sudah dihapus.',
        //                             'success'
        //                         );
        //                     }
        //                 },
        //                 error: function() {
        //                     console.log("Failed to delete data from server");
        //                 }
        //             });
        //         }
        //     });
        // });
    </script>
@endsection
