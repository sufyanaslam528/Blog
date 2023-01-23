@extends('layouts.header')
@section('content')
<x-app-layout>
    <div class="col-md-4 mt-5 ms-5">
        @auth
        @if(auth()->user()->is_admin == 1)
        <div class="list-group">
            <a href="/subscriber" class="list-group-item list-group-item-action"><i class="fa-solid fa-list"></i> Subscribers List</a>
            <a href="/blog" class="list-group-item list-group-item-action"><i class="fa-solid fa-blog"></i> Blog List</a>
            <a href="/blog/create" class="list-group-item list-group-item-action"><i class="fa-solid fa-blog"></i> Create Blog</a>
            <a href="/subscriber/create" class="list-group-item list-group-item-action"><i class="fa-solid fa-blog"></i> Create Subscriber</a>
        </div>
        @else
        <div class="list-group">
            <a href="/blog" class="list-group-item list-group-item-action"><i class="fa-solid fa-blog"></i> Blog List</a>
            <a href="/blog/create" class="list-group-item list-group-item-action"><i class="fa-solid fa-blog"></i> Create Blog</a>
        </div>
        @endif
        @endauth
    </div>
    <div class="row" id="card_div">
        <h1 class="mb-5 text-center card_heading">Blogs</h1>
        <div class="mb-5">
            {{ $blogs->links() }}
        </div>
        @foreach($blogs as $blog)
        <div class="col-md-3">
            <div class="card" style="width: 15rem;">
                <img src="{{ asset('storage/images/'.$blog->image) }}" width="100%" height="100%" class="card-img-top" alt="...">
                <div class="card-body">
                    <h2 class="card-title text-center">{{$blog->title}}</h2>
                    <p class="card-text">
                        {{ substr($blog->content,0,30,) }}...
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>
@endsection