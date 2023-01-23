@extends('layouts.header')
@section('content')

<form id="postForm">
    <div class="row main_div">
        <div class="alert alert-success" role="alert" id="success" style="display:none">
            <strong> Congrats!</strong> Subscriber created successfully.
            <span class="closebtn btn_alrt_success" onclick="this.parentElement.style.display='none';">× </span>
        </div>
        <div class="alert alert-danger" role="alert" id="error" style="display: none;">
            <strong> Oops!</strong> Username is required.
            <span class="closebtn usr-alert" onclick="this.parentElement.style.display='none';">× </span>
            </button>
        </div>
        <div class="alert alert-danger" role="alert" id="password" style="display: none;">
            <strong> Oops!</strong> Password is required.The password must be at least 8 characters.
            <span class="closebtn pass_alert" onclick="this.parentElement.style.display='none';">× </span>
            </button>
        </div>
        <h3 class="mb-5 subcr_heading">Create Subscriber</h3>
        <div id="fingerprint" class="fp" style="display:none"></div>
        <div class="col-md-6">
            <div class="col-md-12 mb-4">
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name" required>
            </div>
            <div class="col-md-12 mb-4">
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Your Email" required>
            </div>
            <div class="col-md-12 mb-4">
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Your Username" required>
            </div>
            <div class="col-md-12 mb-4">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Your Password" required>
            </div>
            <div class="col-md-12 mb-4 ">
                <select name="status" id="status" class="form-select">
                    <option disabled selected value> -- select an option -- </option>
                    <option value="Subscribed">Subscribed</option>
                    <option value="UnSubscribed">UnSubscribed</option>
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
<script src="{{ asset('js/fingerprint.js') }}" defer></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#saveData").click(function(e) {
        e.preventDefault();
        var name = $("input[name=name]").val();
        var username = $("input[name=username]").val();
        var email = $("input[name=email]").val();
        var unique_id = $("#fingerprint").text();
        if (username == "") {
            $("#error").css("display", "block");
        }
        var password = $("input[name=password]").val();
        if ((password == "") || (password.length < 8)) {
            $("#password").css("display", "block");
        }
        var status = $('#status').find(":selected").val();
        $.ajax({
            type: 'POST',
            url: "{{ route('subscriber.store') }}",
            data: {
                name: name,
                username: username,
                password: password,
                status: status,
                email: email,
                unique_id: unique_id
            },
            success: function(data) {
                $("#success").css("display", "block");
                $('#postForm').trigger("reset");
            },
            error: function(data) {}
        });
    });
</script>

@endsection