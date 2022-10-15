@extends('layouts.main')

@section('title','Profile')
@section('page_title','Profile')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="/">Home</a></li>
<li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Profile</h3>
    </div>
    <form class="show-data">
        <div class="card-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" disabled>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" name="email" disabled>
            </div>
            <div class="form-group">
                <label>Created at</label>
                <input type="text" class="form-control" name="created_at" disabled>
            </div>
        </div>


          <div class="col-md-2">
            <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modalUpdateProfile">
                Update Profile
            </button>
         </div>
         <br/>

         <div class="col-md-2">
            <button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#modalUpdatePassword">
                Update Password
            </button>
         </div>
    </form>

  </div>

<!-- Modal Update Profile-->
<div class="modal fade" id="modalUpdateProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-update-profile" method="POST">
            @csrf
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Profile</h1>
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

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" placeholder="Email" name="email" placeholder="Please enter Email..." required>
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

<!-- Modal Update Password-->
<div class="modal fade" id="modalUpdatePassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-update-password" method="POST">
            @csrf
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Change Password</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

                <input type="hidden" name="id">

                <div class="form-group">
                    <label>Old Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="oldPassword" placeholder="Please enter Password..." required>
                </div>
                <div class="form-group">
                    <label>new Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="newPassword" placeholder="Please enter newPassword..." required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="confirmPassword" placeholder="Please enter Confrm Password..." required>
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
            url: "/profile/getDataProfile",
            data: {},
            success: function (result) {

                var showData = $('.show-data');
                showData.find("input[name=name]").val(result.name);
                showData.find("input[name=email]").val(result.email);
                showData.find("input[name=created_at]").val(result.created_at);

                var form = $('.form-update-profile');
                form.find("input[name=id]").val(result.id);
                form.find("input[name=name]").val(result.name);
                form.find("input[name=email]").val(result.email);
                form.find("input[name=created_at]").val(result.created_at);
            },
            error: function(xhr, error){
                console.log(xhr);
                console.log(error);
            }
        });
    }

    $(document).on('submit','.form-update-profile', function(e){
        e.preventDefault();

        var form = $(this);
        var inputToken = form.find("input[name=_token]");
        $.ajax({
            type: "POST",
            url: "/profile/updateProfile",
            data: {
                _token:inputToken.val(),
                id: form.find("input[name=id]").val(),
                name: form.find("input[name=name]").val(),
                email: form.find("input[name=email]").val(),
            },
            success: function (result) {
                if(result.status){
                    $("#modalUpdateProfile").modal('hide');
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

    $(document).on('submit','.form-update-password', function(e){
        e.preventDefault();

        var form = $(this);
        var inputToken = form.find("input[name=_token]");
        $.ajax({
            type: "POST",
            url: "/profile/updatePassword",
            data: {
                _token:inputToken.val(),
                oldPassword: form.find("input[name=oldPassword]").val(),
                newPassword: form.find("input[name=newPassword]").val(),
                confirmPassword: form.find("input[name=confirmPassword]").val(),
            },
            success: function (result) {
                if(result.status){
                    $("#modalUpdatePassword").modal('hide');
                    alert(result.message);
                    window.location.href = "/logout";
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




</script>

@endpush
