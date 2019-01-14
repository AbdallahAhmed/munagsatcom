@extends('layouts.master')

@section('title',$page->title)

@section('content')
    <section class="container">
        <div class="res-box">
            <div class="about">
                <h2>{{$page->title}}</h2>
                {!! $page->content !!}
            </div>
        </div>
    </section>
@endsection