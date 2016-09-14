@if(isset($partners) && count($partners)> 0)
<div class="full-width bg-white">
    <div class="content col_padding_bottom">
        <div class="headbox">
            <span class="text_left text-uppercase">Đối Tác</span>
        </div>
        <hr>
        <div class="loader-container active" >
            <div class="content">
                <div class="gobyArtIcon spinner">S</div>
                <div class="icon-label">Đang Tải</div>
            </div>
        </div>
        <div class="partner-slideshow-wrapper hidden-data">
            <div id="partner-slideshow">
                @foreach($partners as $partner)
                    <div>
                        <img alt="{{$partner->original_name}}" src="{{$partner->image_url}}">
                    </div>
                @endforeach
            </div>
            <a class="partner-bt-left gobyArtIcon" onclick="$('#partner-slideshow').slick('slickPrev');">J</a>
            <a class="partner-bt-right gobyArtIcon" onclick="$('#partner-slideshow').slick('slickNext');">K</a>
        </div>
    </div>
</div>
@endif
