@extends('layouts.main')

@section('title','Comment')
@section('page_title','Comment')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="/">Home</a></li>
<li class="breadcrumb-item active">Comment</li>
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
                            <th>News</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Comment</th>
                            <th>Like</th>
                            <th>Date Comment</th>
                            <th>Time Comment</th>
                            <th>Is Active</th>
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
                    <label>News Title</label>
                    <select class="form-control" name="id_news">
                        @foreach ($data as $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" placeholder="Name" name="name" placeholder="Please enter Name..." required>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="number" class="form-control" placeholder="Phone Number" name="phone_number" placeholder="Please enter.." required>
                </div>
                <div class="form-group">
                    <label>Comment</label>
                    <textarea name="comment" class="form-control" rows="3" placeholder="Enter Comment..."></textarea>
                </div>

                <div class="form-group">
                    <label>Like</label>
                    <select class="form-control" name="like">
                        <option value="1">like</option>
                        <option value="0">dislike</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>is_active</label>
                    <select class="form-control" name="is_active">
                        <option value="enable">Enable</option>
                        <option value="disable">Disable</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Date Comment</label>
                    <input type="date" class="form-control" placeholder="Phone Number" name="date" placeholder="Please enter.." required>
                </div>

                <div class="form-group">
                    <label>Time Comment</label>
                    <input type="time" class="form-control" placeholder="Phone Number" name="time" placeholder="Please enter.." required>
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
                    <label>News Title</label>
                    <select class="form-control" name="id_news">
                        @foreach ($data as $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" placeholder="Name" name="name" placeholder="Please enter Name..." required>
                    <input type="hidden" name="id">
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="number" class="form-control" placeholder="Phone Number" name="phone_number" placeholder="Please enter.." required>
                </div>
                <div class="form-group">
                    <label>Comment</label>
                    <textarea name="comment" class="form-control" rows="3" placeholder="Enter Comment..."></textarea>
                </div>

                <div class="form-group">
                    <label>Like</label>
                    <select class="form-control" name="like">
                        <option value="1">like</option>
                        <option value="0">dislike</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>is_active</label>
                    <select class="form-control" name="is_active">
                        <option value="enable">Enable</option>
                        <option value="disable">Disable</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Date Comment</label>
                    <input type="date" class="form-control" placeholder="Phone Number" name="date" placeholder="Please enter.." required>
                </div>

                <div class="form-group">
                    <label>Time Comment</label>
                    <input type="time" class="form-control" placeholder="Phone Number" name="time" placeholder="Please enter.." required>
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

@endsection

@push('custom-script')
<script>
    $(function(){
        readData();
    });
    function readData(){
        $.ajax({
            type: "GET",
            url: "/comment/getdata",
            data: {},
        }).done(function(result){
                $('#dataTable').DataTable({
                    "paging":true,
                    "ordering":true,
                    "responsive":true,
                    "destroy":true,
                    "data":result.data,
                    "columns":[
                        {"data": "no"},
                        {"data": "news.title"},
                        {"data": "name"},
                        {"data": "phone_number"},
                        {"data": "comment"},
                        {"data": "like"},
                        {"data": "date_comment"},
                        {"data": "time_comment"},
                        {"data": "is_active"},
                        {"data": "id"},

                    ],
                    "columnDefs":[
                        {
                            "targets" : 9,
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
                        },
                        {
                            "targets" : 5,
                            "data" : "like",
                            "render":function(data, type, row){
                                return row.like == 1 ? 'Like' : 'Dislike';
                            }
                        }
                    ],
                });
        }).fail(function(xhr, error){
            console.log(xhr);
            console.log(error);
        });
    }


    $(document).on('submit','.form-create', function(e){
        e.preventDefault();
        var form = $(this);

        var inputToken = form.find("input[name=_token]");
        $.ajax({
            type: "POST",
            url: "/comment/createdata",
            data: form.serialize(),

        }).done(function(result){
            if(result.status){
                $('#modalCreate').modal('hide');
                alert(result.message);
                readData();
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
            url: "/comment/getdata",
            data: {
                id: $(this).data('id')
            }
        }).done(function(result){
                var form = $('.form-edit');
                var data = result.data;

                form.find('input[name=id]').val(data.id);
                form.find('select[name=id_news]').val(data.id_news);
                form.find('input[name=name]').val(data.name);
                form.find('input[name=phone_number]').val(data.phone_number);
                form.find('textarea[name=comment]').val(data.comment);
                form.find('select[name=like]').val(data.like);
                form.find('input[name=date]').val(data.date_comment);
                form.find('input[name=time]').val(data.time_comment);
                form.find('select[name=is_active]').val(data.is_active);

                $('#modalEdit').modal('show');

        }).fail(function(xhr, error){
            console.log(xhr);
            console.log(error);
        });

    });

    $(document).on('submit','.form-edit', function(e){
        e.preventDefault();
        var form = $(this);
        var inputToken = form.find("input[name=_token]");
        var url = '/comment/updatedata/'+form.find('input[name=id]').val();
        $.ajax({
            type: "POST",
            url: url,
            data: {
                _token:inputToken.val(),
                id_news: form.find('select[name=id_news]').val(),
                name: form.find('input[name=name]').val(),
                phone_number: form.find('input[name=phone_number]').val(),
                comment: form.find('textarea[name=comment]').val(),

                like: form.find('select[name=like]').val(),
                date: form.find('input[name=date]').val(),
                time: form.find('input[name=time]').val(),
                is_active: form.find('select[name=is_active]').val(),
            },
        }).done(function(result){
            if(result.status){
                $('#modalEdit').modal('hide');
                alert(result.message);
                readData();
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
                url : "/comment/deletedata/"+$(this).data('id'),
                type : 'POST',
                data : {
                    _token: inputToken.val(),
                }
            }).done(function(result){
                inputToken.val(result.newToken);
                    readData();

            }).fail(function(xhr, error){
                console.log(xhr);
                console.log(error);
            });
        }



    });

</script>

@endpush

