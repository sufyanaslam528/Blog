@extends('layouts.header')
@section('content')
<x-app-layout>
    <div class="col-md-4 mt-5 ms-5">
        <div class="list-group">
            <a href="/subscriber" class="list-group-item list-group-item-action"><i class="fa-solid fa-list"></i> Subscribers List</a>
            <a href="/blog" class="list-group-item list-group-item-action"><i class="fa-solid fa-blog"></i> Blog List</a>
            <a href="/blog/create" class="list-group-item list-group-item-action"><i class="fa-solid fa-blog"></i> Create Blog</a>
        </div>
    </div>
</x-app-layout>
@endsection