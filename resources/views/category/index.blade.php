@extends('layouts.main')

@section('title','Categori')
@section('page_title','Category')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="/">Home</a></li>
<li class="breadcrumb-item active">Category</li>
@endsection

@section('content')
<div class="row">
    @if (Session::get('message'))
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-exclamation-triangle"></i>{{ Session::get('message') }}</h5>
    </div>
    @endif

    <div class="col-md-10"></div>
    <div class="col-md-2">
        <a href="/category/create" class="btn btn-block btn-success">Create</a>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
      <h3 class="card-title">Table Category</h3>

      <div class="card-tools">
        <form action="/category/search" class="input-group input-group-sm" style="width: 150px;">
            @csrf
            <input type="text" name="search" class="form-control float-right" placeholder="Search">

          <div class="input-group-append">
            <button type="submit" class="btn btn-default">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
      <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th>No</th>
            <th>Category Name</th>
            <th>Description</th>
            <th>Status Active</th>
            <th>Created At</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($data as $index=>$item )
            <form action="/category/destroy/{{ $item->id }}" method="post">
                @csrf
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->status_active }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary">Action</button>
                            <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" href="/category/edit/{{ $item->id }}">Edit</a>
                            <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure to delete this data!!')">Delete</a>
                            {{-- <a class="dropdown-item" href="/delete/{{ $item->id }}">Delete</a> --}}
                            </div>
                        </div>
                    </td>
                </tr>
            </form>
          @endforeach
        </tbody>
      </table>
      <div class="float-right mr-3 mt-3">
        {{ $data->links('pagination::bootstrap-4') }}
      </div>
    </div>
    <!-- /.card-body -->
  </div>


  @endsection
