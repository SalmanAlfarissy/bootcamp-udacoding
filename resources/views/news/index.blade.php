@extends('layouts.main')

@section('title','News')
@section('page_title','News')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="/">Home</a></li>
<li class="breadcrumb-item active">News</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10"></div>
    <div class="col-md-2">
        <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modalCreate">
            Create
        </button>
    </div>

    <div class="col-md-12">
        <div class="card-header">
            <h3 class="card-title">List Data</h3>
        </div>
        <div class="card">

            <div class="card-body table-responsive">
                <table class="table table-bordered text-nowrap" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Create At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create-->
<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-create" method="POST">
            @csrf
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Create Data</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" placeholder="Name" name="title" placeholder="Please enter Title..." required>
                </div>
                <div class="form-group">
                <label>Category</label>
                    <select class="form-control" name="id_category">
                        @foreach ($data as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Enter Description..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-edit" method="POST">
            @csrf
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" placeholder="Name" name="title" placeholder="Please enter Title..." required>
                    <input type="hidden" name="id">
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select class="form-control" name="id_category">
                        @foreach ($data as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Enter Description..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update changes</button>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="loadingData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div align='center'>
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
      </div>
    </div>
</div>

@endsection

@push('custom-script')
<script>

    $(function(){
        readData();
    });

    function readData(){
        $.ajax({
            type: "GET",
            url: "/news/getdata",
            data: {},
            beforeSend: function(){
                $('#loadingData').modal('show');
            },
        }).done(function(result){
            $('#loadingData').modal('hide');
                $('#dataTable').DataTable({
                    "paging":true,
                    "ordering":true,
                    "responsive":true,
                    "destroy":true,
                    "data":result.data,
                    "columns":[
                        {"data": "no"},
                        {"data": "title"},
                        {"data": "category.name"},
                        {"data": "description"},
                        {"data": "created_at"},
                        {"data": "id"},

                    ],
                    "columnDefs":[
                        {
                            "targets" : 5,
                            "data" : "id",
                            "render":function(data, type, row){
                                return '<div class="btn-group">'+
                                '<button type="button" class="btn btn-primary">Action</button>'+
                                '<button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">'+
                                '<span class="sr-only">Toggle Dropdown</span>'+
                                '</button>'+
                                '<div class="dropdown-menu" role="menu">'+
                                '<button class="dropdown-item btn-edit" data-id="'+row.id+'">Edit</button>'+
                                '<button class="dropdown-item btn-delete" data-id="'+row.id+'">Delete</button>'+
                                '</div>'+
                            '</div>';
                            }
                        }
                    ],
                });
        }).fail(function(xhr, error){
            console.log(xhr);
            console.log(error);
        });
    }

    $(document).on('click', '.btn-edit', function(){
        $.ajax({
            type: "GET",
            url: "/news/getdata",
            data: {
                id: $(this).data('id'),
            },
            success: function (result) {
                if (result.data) {
                    var form = $('.form-edit');
                    var data = result.data;

                    form.find('input[name=title]').val(data.title);
                    form.find('select[name=id_category]').val(data.id_category);
                    form.find('textarea[name=description]').val(data.description);
                    form.find('input[name=id]').val(data.id);
                    $('#modalEdit').modal('show');

                }else{
                    alert('Data not found!!');
                }
            },
            error: function(xhr, error){
                console.log(xhr);
                console.log(error);
            }
        });
    });

    $(document).on('submit', '.form-edit', function(e){
        e.preventDefault();
        var form = $(this);
        var inputToken = form.find("input[name=_token]").val();

        $.ajax({
            type: "POST",
            url: "/news/updatedata/"+form.find("input[name=id]").val(),
            data: {
                _token:inputToken,
                title: form.find("input[name=title]").val(),
                id_category: form.find("select[name=id_category]").val(),
                description: form.find("textarea[name=description]").val(),
            },
            success: function (result) {
                if(result.status){
                    $("#modalEdit").modal('hide');
                    alert(result.message);
                    readData();
                }else{
                    alert(result.message);
                }
            },
            error: function(xhr, error){
                console.log(xhr);
                console.log(error);
            }
        });

    })

    $(document).on('submit','.form-create', function(e){
        e.preventDefault();

        var form = $(this);
        var inputToken = form.find("input[name=_token]");
        $.ajax({
            type: "POST",
            url: "/news/createdata",
            data: {
                _token:inputToken.val(),
                title: form.find("input[name=title]").val(),
                id_category: form.find("select[name=id_category]").val(),
                description: form.find("textarea[name=description]").val(),
            },
            success: function (result) {
                if(result.status){
                    $("#modalCreate").modal('hide');
                    alert(result.message);
                    readData();
                }else{
                    alert(result.message);
                }

            },
            error : function(xhr, error){
                console.log(xhr);
                console.log(error);
            }
        });
    })

    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();

        if(confirm('Apakah kamu ingin menghapus data ini?')){
            var inputToken = $('input[name=_token]');
            $.ajax({
                url : "/news/deletedata/"+$(this).data('id'),
                type : 'POST',
                data : {
                    _token: inputToken.val(),
                }
            }).done(function(result){
                inputToken.val(result.newToken);
                if(result.status){
                    readData();
                }else{
                    alert(result.message);
                }

            }).fail(function(xhr, error){
                console.log(xhr);
                console.log(error);
            });
        }

    })




</script>

@endpush
