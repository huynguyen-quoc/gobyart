@extends('layouts.main')
@section('content')

@endsection
@section('scripts')
    {{--@include('partials.scripts')--}}
    <script type="text/javascript">
        $(function(){
            window.conApp.hideSpin();
        });
    </script>
@endsection