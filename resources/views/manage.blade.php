@extends('layouts.manage_app')

@section('header')
    <laravel-manage-header
        app_name="{{ config('app.name', 'Laravel') }}"
        user_name="{{ Auth::user()->name }}"
        route_logout="/logout"
        :csrf="{{ json_encode( csrf_token() ) }}"
    />
@endsection

@section('sidebar')
    <laravel-sidebar />
@endsection

@section('main')
    <laravel-main
        token="{{Auth::user()->api_token}}"
        :obj="{{ json_encode([
                'post' => $post['post'],
                'term' => $term
            ]) }}"
    />
@endsection

@section('footer')

@endsection


