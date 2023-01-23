@extends('layouts.header')
@section('content')
<form id="postForm" enctype="multipart/form-data">
    @csrf
    <div class="row main_div">

        <div class="alert alert-success" role="alert" id="success" style="display:none">
            <strong> Congrats!</strong> Blog created successfully.
            <span class="closebtn btn_alrt_success" onclick="this.parentElement.style.display='none';">× </span>
        </div>
        <h3 class="mb-5 main_heading">Create Blog</h3>
        <div class="col-md-6">
            <div class="col-md-12 mb-4">
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Your Title" required>
            </div>
            <div class="col-md-12 mb-4">
                <input type="date" class="form-control" id="publish_date" name="publish_date" placeholder="publish date">
            </div>
            <div class="col-md-12 mb-4">
                <textarea rows="4" cols="37" class="form-control" name="content" id="content" form="usrform" placeholder="Enter Your Content"></textarea>
            </div>
            <div class="col-md-12 mb-4">
                <input type="file" name="file" id="file" required>
            </div>

            <div class="col-md-12 mb-4">
                <button type="submit" id="saveData" class="col-md-12 btn btn-primary">Save</button>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12 mb-4">
                <img src="{{ asset('/images/blog.png') }}" class="blog_img">
            </div>
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
    $("#postForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        var content = $("#content").val();
        fd.append('content', content)
        $.ajax({
            url: "{{ route('blog.store') }}",
            type: 'POST',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                $("#success").css("display", "block");
                $('#postForm').trigger("reset");
                $('#content').val('');
            },
            error: function(data) {
            }
        });
    });
</script>

@endsection