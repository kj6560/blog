@extends('layouts.guestlayout')

@section('content')
<!-- Page Header-->
<header class="masthead" style="background-image: url('theme/assets/img/home-bg.jpg')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="site-heading">
                    <h1>{{$site_settings['site_name']}}</h1>
                    <span class="subheading">Your Favourite Place To Know More</span>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main Content-->
<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">

            @foreach($posts as $post)
            <!-- Post preview-->
            <div class="post-preview">
                <a href="/postDetails/{{$post->slug}}">
                    <h2 class="post-title">{{$post->title}}</h2>
                    <h3 class="post-subtitle">{{$post->sub_title}}</h3>
                </a>
                <p class="post-meta">
                    Posted by
                    <a href="#!">{{$post->name}}</a>
                    on {{date('d F Y',strtotime($post->created_at))}}
                </p>
            </div>
            <!-- Divider-->
            <hr class="my-4" />
            @endforeach

            <!-- Pager-->
            <div class="d-flex justify-content-end mb-4"><a class="btn btn-primary text-uppercase" href="/posts">Older Posts →</a></div>
        </div>
    </div>
</div>
@endsection