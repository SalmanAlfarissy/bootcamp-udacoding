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

<form class="form-token">
    @csrf
</form>


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
        readData();
    });

    function readData(){
        $.ajax({
            type: "GET",
            url: "/news/getDataTrash",
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
                                '<button class="dropdown-item btn-restore" data-id="'+row.id+'">Restore</button>'+
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


    $(document).on('click', '.btn-restore', function(e){
        e.preventDefault();

        if(confirm('Apakah kamu ingin restore data ini?')){
            var inputToken = $('input[name=_token]');
            $.ajax({
                url : "/news/restoreData/"+$(this).data('id'),
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
    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();

        if(confirm('Apakah kamu ingin menghapus data ini?')){
            var inputToken = $('input[name=_token]');
            $.ajax({
                url : "/news/deleteTrash/"+$(this).data('id'),
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
