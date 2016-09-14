@extends("frontend.layout.master")
@section("meta")
    @if(isset($siteOptions))
        <title>{{!isset($siteOptions['name']) ? '' : $siteOptions['name']}}</title>
        <meta name="keywords" content="{{!isset($siteOptions['keyword']) ? '' :$siteOptions['keyword']}}">
        <meta name="description" content="{{!isset($siteOptions['description']) ? '' : $siteOptions['description']}}">
        <meta name="copyright" content="{{!isset($siteOptions['copyright']) ? '' : $siteOptions['copyright']}}">
        <meta name="author" content="{{!isset($siteOptions['author']) ? 'GobyArt' : $siteOptions['author']}}">
    @endif
@endsection
@section("content")

    @include("frontend.pages.includes.about-content")

    @include("frontend.pages.includes.team")

    @include("frontend.pages.includes.about-event")
@endsection
@section("scripts")
    <script type="text/javascript">


        $(function () {
            AboutPage.initPage();

        })


    </script>
@endsection