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
    <div class="full-width bg-grey">
        <div class="content">
            <div class="artist-filter">
                <ul>
                    <li class="{{ Request::segment(3) == '' || Request::segment(3) == 'tat-ca' ? 'selected' : '' }}" data-value="tat-ca">
                        <a href="{{ (Request::segment(3) != '') ? preg_replace('~/([^/]*)$~',  '/tat-ca', Request::url()) : Request::url().'/tat-ca'}}">Tất Cả</a>
                    </li>
                    @foreach ($filter as $item)

                        <li class="{{ Request::segment(3) == strtolower($item) ? 'selected' : '' }}" data-value="{{$item}}">
                            <a href="{{ (Request::segment(3) != '') ? preg_replace('~/([^/]*)$~',  '/'.strtolower($item), Request::url()) : Request::url().'/'. strtolower($item)}}">{{$item}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="artist-filter-type">
                {{--sort by <span>alphabet</span>--}}
            </div>
        </div>
    </div>
    @include("frontend.pages.includes.artists")
@endsection
@section("scripts")
    <script id="imagePopOverTemplate1" type="text/x-kendo-template">
        # if(data.length > 0){ #
            <div class="grid-item"> <img src="/upload/low/#= data[0].file_id + '.' + data[0].extension#"></div>
        # } #
        #  if(data.length > 1) { #
            <div class="grid-item"> <img src="/upload/low/#= data[1].file_id + '.' + data[1].extension#"></div>
        #} #
    </script>
    <script id="detailTemplate" type="text/x-kendo-template">
        # for(var i =0; i< data.length ; i++ ){ #
            <div class="model-info-detail">
                # if(data[i].title !== '' && data[i].value !== ''){ #
                <span class="model-detail-label">#=data[i].title#</span>
                # } #
                # if(data[i].value !== ''){ #
                <span class="model-detail-value" >#=data[i].value#</span>
                # } #

            </div>
        # } #
    </script>
    <script id="imagePopOverTemplate2" type="text/x-kendo-template">
        # if(data.length > 2){ #
            <div class="grid-item"> <img src="/upload/low/#= data[2].file_id + '.' + data[2].extension#"></div>
        # }#
        # if(data.length > 3) { #
            <div class="grid-item"> <img src="/upload/low/#= data[3].file_id + '.' + data[3].extension#"></div>
        #}#
    </script>
    <script type="text/javascript">

        $(function () {
           ArtistPage.initPage({{$totalPage}});
        })

    </script>
@endsection