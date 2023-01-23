@extends('layouts.header')
@section('content')

<form id="postForm" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row main_div">
        <div class="alert alert-success" role="alert" id="success" style="display:none">
            <strong> Congrats!</strong> Blog updated successfully.
            <span class="closebtn btn_alrt_success" onclick="this.parentElement.style.display='none';">× </span>
        </div>
        <h3 class="mb-5 main_heading">Update Blog</h3>
        <div class="col-md-6">
            <div class="col-md-12 mb-4">
                <input type="text" class="form-control" id="title" name="title" value="{{$data->title}}">
            </div>
            <div class="col-md-12 mb-4">
                <input type="date" class="form-control" id="publish_date" value="{{$data->publish_date}}" name="publish_date" placeholder="publish date">
            </div>

            <div class="col-md-12 mb-4">
                <input type="file" name="file" accept="image/*" id="file">
                <img src="{{ asset('storage/images/'.$data->image) }}" class="img-fluid img-thumbnail" width="150">
            </div>
            <div class="col-md-12 mb-4">
                <button type="submit" id="saveData" class="col-md-12 btn btn-primary">Save</button>
            </div>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('/images/blog.png') }}" class="blog_img">
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
        var fd = new FormData(this);
        $.ajax({
            type: "POST",
            url: "{{ route('blog.update',$data->id) }}",
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                $("#success").css("display", "block");
            },
            error(data) {
            }
        })
    })
</script>

@endsection