@extends('layouts.main')

@section('title','Categori2')
@section('page_title','Category2')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="/">Home</a></li>
<li class="breadcrumb-item active">Category2</li>
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
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status Aktive</th>
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
                    <label>Name</label>
                    <input type="text" class="form-control" placeholder="Name" name="name" placeholder="Please enter Name..." required>
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
            <h1 class="modal-title fs-5" id="exampleModalLabel">Create Data</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" placeholder="Name" name="name" placeholder="Please enter Name..." required>
                </div>

                <select class="form-control" name="status_active">
                    <option value="ACTIVE">Active</option>
                    <option value="NONACTIVE">Non Active</option>
                </select>

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
    <div class="modal-dialog">
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
        loadData();
    });
    function loadData(){
        $.ajax({
        type: "GET",
        url: "/category2/getdata",
        data: {},
        beforeSend: function(){
            $('#loadingData').modal('show');
        },
        }).done(function(result){
            $('#loadingData').modal('hide')
            $('#dataTable').DataTable({
                "paging":true,
                "searching":true,
                "ordering":true,
                "responsive":true,
                "destroy":true,
                "data":result.data,
                "columns":[
                    {"data": "no"},
                    {"data": "name"},
                    {"data": "description"},
                    {"data": "status_active"},
                    {"data": "created_at"},
                    {"data": "id"},

                ],
                "columnDefs": [
                    {
                        "targets" : 5,
                        "data":"id",
                        "render":function(data, type, row){
                            return '<div class="btn-group">'+
                                '<button type="button" class="btn btn-primary">Action</button>'+
                                '<button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">'+
                                '<span class="sr-only">Toggle Dropdown</span>'+
                                '</button>'+
                                '<div class="dropdown-menu" role="menu">'+
                                '<button class="dropdown-item btn-edit" data-id="'+row.id+'">Edit</button>'+
                                '<button class="dropdown-item btn-delete" data-id="'+row.id+'">Delete</button>'+
                                '<input type="button" class="dropdown-item btn-status" value="'+(row.status_active == 'ACTIVE' ? 'Deactived' : 'Actived')+'" data-id="'+row.id+'">'+
                                '</div>'+
                            '</div>';
                        }
                    }
                ],

            });


        }).fail(function(xhr, error){
            console.log('xhr', xhr.status);
            console.log('error', error);
        });

    }


    $(document).on('submit','.form-create', function(e){
        e.preventDefault();
        var form = $(this);
        var inputToken = form.find("input[name=_token]");
        $.ajax({
            type: "POST",
            url: "/category2/createdata",
            data: {
                _token:inputToken.val(),
                name: form.find('input[name=name]').val(),
                description: form.find('textarea[name=description]').val(),
            },
        }).done(function(result){
            if(result.status){
                $('#modalCreate').modal('hide');
                alert(result.message);
                loadData();
            }else{
                alert(result.message);
            }

        }).fail(function(xhr, error){
            console.log(xhr);
            console.log(error);
        });
    });

    $(document).on('click', '.btn-edit' ,function (e) {
        e.preventDefault();

        $.ajax({
            type: "GET",
            url: "/category2/getdata",
            data: {
                id: $(this).data('id')
            }
        }).done(function(result){
            if (result.data) {
                var form = $('.form-edit');
                var data = result.data;

                form.find('input[name=name]').val(data.name);
                form.find('input[name=id]').val(data.id);
                form.find('textarea[name=description]').val(data.description);
                form.find('select[name=status_active]').val(data.status_active);
                $('#modalEdit').modal('show');

            }else{
                alert('Data not found!!');
            }

        }).fail(function(xhr, error){
            console.log(xhr);
            console.log(error);
        });

    });

    $(document).on('submit','.form-edit', function(e){
        e.preventDefault();
        var form = $(this);
        var inputToken = form.find("input[name=_token]");
        var url = '/category2/updatedata/'+form.find('input[name=id]').val();
        $.ajax({
            type: "POST",
            url: url,
            data: {
                _token:inputToken.val(),
                name: form.find('input[name=name]').val(),
                description: form.find('textarea[name=description]').val(),
                status_active: form.find('select[name=status_active]').val(),
            },
        }).done(function(result){
            if(result.status){
                $('#modalEdit').modal('hide');
                alert(result.message);
                loadData();
            }else{
                alert(result.message);
            }

        }).fail(function(xhr, error){
            console.log(xhr);
            console.log(error);
        });
    });

    $(document).on('click','.btn-delete', function(e){
        e.preventDefault();

        if(confirm('Apakah kamu ingin menghapus data ini?')){
            var inputToken = $('input[name=_token]');
            $.ajax({
                url : "/category2/deletedata/"+$(this).data('id'),
                type : 'POST',
                data : {
                    _token: inputToken.val(),
                }
            }).done(function(result){
                inputToken.val(result.newToken);
                if(result.status){
                    loadData();
                    $('#loadingData').modal('hide');

                }else{
                    alert(result.message);
                }

            }).fail(function(xhr, error){
                console.log(xhr);
                console.log(error);
            });
        }



    });

    $(document).on('click','.btn-status', function(e){
        e.preventDefault();

        var inputToken = $('input[name=_token]');
        $.ajax({
            url : "/category2/updateStatus/"+$(this).data('id'),
            type : 'POST',
            data : {
                _token: inputToken.val(),
            }
        }).done(function(result){
            inputToken.val(result.newToken);
            if(result.status){
                alert(result.message);
                loadData();
                $('#loadingData').modal('hide');
            }else{
                alert(result.message);
            }

        }).fail(function(xhr, error){
            console.log(xhr);
            console.log(error);
        });

    });

</script>

@endpush

