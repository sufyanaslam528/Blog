@extends('layouts.header')
@section('content')

<form id="postForm">
    <div class="row main_div">
        <div class="alert alert-success" role="alert" id="success" style="display:none">
            <strong> Congrats!</strong> Subscriber Updated successfully.
            <span class="closebtn subscr_alert" onclick="this.parentElement.style.display='none';">× </span>
        </div>
        <div class="alert alert-danger" role="alert" id="error" style="display: none;">
            <strong> Oops!</strong> Username is required.
            <span class="closebtn usr-alert" onclick="this.parentElement.style.display='none';">× </span>
            </button>
        </div>
        <div class="alert alert-danger" role="alert" id="passwordvld" style="display: none;">
            <strong> Oops!</strong> Password is required.
            <span class="closebtn usr-alert" onclick="this.parentElement.style.display='none';">× </span>
            </button>
        </div>
        <h3 class="mb-5 subcr_heading">Edit Subscriber</h3>
        <div class="col-md-6">
            <div class="col-md-12 mb-4">
                <input type="text" class="form-control" id="name" value="{{$data->name}}" name="name" placeholder="Enter Your Name" required>
            </div>
            <div class="col-md-12 mb-4">
                <input type="text" class="form-control" id="username" value="{{$data->username}}" name="username" placeholder="Enter Your Username" required>
            </div>
            <div class="col-md-12 mb-4">
                <input type="text" class="form-control" id="password" value="{{$data->password}}" name="password" placeholder="Enter Your Password" required>
            </div>
            <div class="col-md-12 mb-4 ">
                <select name="status" id="status" class="form-select">
                    <option value="Subscribed" {{ $data->status == "Subscribed" ? 'selected' : '' }}>Subscribed</option>
                    <option value="UnSubscribed" {{ $data->status == "UnSubscribed" ? 'selected=' : '' }}>UnSubscribed</option>

                </select>
            </div>
            <div class="col-md-12 mb-4">
                <button type="button" id="saveData" class="col-md-12 btn btn-primary">Save</button>
            </div>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('/images/register.png') }}" class="subs_img">
        </div>
    </div>
</form>
<a href="/home"><button class="btn btn-primary back_create_btn">Back</button></a>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#saveData").click(function(e) {
        e.preventDefault();
        var edit_id = $(this).data('id');
        var name = $('#name').val()
        var username = $("#username").val();
        if (username == "") {
            $("#error").css("display", "block");
        }
        var password = $("#password").val();
        if (password == "") {
            $("#passwordvld").css("display", "block");
        }
        var status = $('#status').find(":selected").val();
        $.ajax({
            type: 'PUT',
            url: "{{route('subscriber.update',$data->id)}}",
            data: {
                name: name,
                username: username,
                password: password,
                status: status
            },
            success: function(data) {
                $("#success").css("display", "block");
            },
            error: function(error) {
                $("#error").css("display", "block");
            }
        });
    });
</script>

@endsection