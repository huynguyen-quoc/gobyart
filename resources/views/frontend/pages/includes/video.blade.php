@if(isset($videoArtist) && count($videoArtist)> 0)
<div class="full-width bg-grey with-bottom-padding ">
    <div class="content video-content">
        <div class="headbox">
            <span class="text_left text-uppercase">Video</span>
        </div>
        <hr>
        <div class="video-slider-wrapper">
            <div id="video-slider">
                @foreach($videoArtist as $file)
                    <div class="item-video-slider grid-item">
                        <div class="model-video-wrapper video_16_9">
                            <div class="video-inner">
                                {{--//www.youtube.com/embed/f4Py54JZC8M--}}
                                <a  class="video-slider-image-wrapper" data-src="{{ $file['file_link'] }}"
                                    style="background-image: url({{asset('assets/upload/'.$file['artist_type'].'/'. $file['artist_name'].'/'.$file['file_name'])}});" tabindex="0">
                                    <div class="video-image-overlay"></div>
                                    <div class="video-image-play-icon">
                                        <span class="gobyArtIcon active">c</span>
                                        <span class="gobyArtIcon">a</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="video-bt-left-wrapper">
                <a class="video-bt-left gobyArtIcon" onclick="$('#video-slider').slick('slickPrev');">J</a>
            </div>
            <div class="video-bt-right-wrapper">
                <a class="video-bt-right gobyArtIcon" onclick="$('#video-slider').slick('slickNext');">K</a>
            </div>
        </div>
    </div>
</div>
@endif
