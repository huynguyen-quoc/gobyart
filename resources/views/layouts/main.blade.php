@extends('layouts.master')
@section('header')

    @include('partials.topnav')

    @include('partials.sidebar')

    <div  class="load-spinner show">
        <div>
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
            <div class="bar4"></div>
        </div>
    </div>
@endsection

@section('footer')

@endsection

