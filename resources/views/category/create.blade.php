@extends('layouts.main')

@section('title','Category')
@section('page_title','Create Category')

@section('breadcrumb')
<li class="breadcrumb-item active"><a href="/">Home</a></li>
<li class="breadcrumb-item active"><a href="/category">Category</a></li>
<li class="breadcrumb-item">Create</li>
@endsection

@section('content')

<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Form Create</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="/category/store" method="POST">
        @csrf
      <div class="card-body">
        <div class="form-group">
          <label>Name</label>
          <input type="text" class="form-control" placeholder="Name" name="name" required>
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="description" class="form-control" rows="3" placeholder="Description"></textarea>
        </div>

      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>

@endsection
