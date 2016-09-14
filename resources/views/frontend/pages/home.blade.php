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
    <div id="title-video">
    </div>
    <div class="artist-type-wrapper">
        <div class="artist-type-content clear-fix">
            <div class="artist-type-content-inner">
                <div class="artist-type-search-content">
                    <div class="artist-text">
                        <p>Bạn đang quan tâm nghệ sĩ nào?</p>
                    </div>

                    <div class="form-search">
                        @foreach($artistTypes as $artistType)
                            <div class="search-item">
                                <input type="checkbox" id="icheck_{{ $artistType->slug }}" name="iCheck" value="{{ $artistType->slug}}">
                                <label for="icheck_{{ $artistType->slug }}" class="">{{ $artistType->name }}</label>
                            </div>
                        @endforeach
                        <div class="search-item">
                            <a type="button" id="filter_btn"  class="btn btn-inverted btn-round text-uppercase">Khám Phá Ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include("frontend.pages.includes.hot-artist")
    {{--<a target="_blank">--}}
        {{--<div class="parallax parallax-spacer" id="home-spacer-image" style="background-image: url({{asset('assets/images/ICE_9427.jpg')}}); background-position: 50% -210.938px;">--}}
        {{--</div>--}}
    {{--</a>--}}
    @include("frontend.pages.includes.slogan")
    @include("frontend.pages.includes.partner")
@endsection
@section("scripts")
    <script type="text/javascript">
        $(function () {

            HomePage.initPage('{{isset($siteOptions) &&  isset($siteOptions['youtube_home']) ? $siteOptions['youtube_home'] : ''}}')
        });
    </script>
@endsection