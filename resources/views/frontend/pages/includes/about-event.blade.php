@if(isset($galleries))
<div class="full-width bg-white">
    <div class="content">
        <div class="headbox">
            <span class="text_left text-uppercase">Sự Kiện GOBYART</span>
        </div>
        <div id="event-loader" class="loader-container active" >
            <div class="content">
                <div class="gobyArtIcon spinner">S</div>
                <div class="icon-label">Loading</div>
            </div>
        </div>
        <hr class="divider">
        <div class="grid-masonry event-masonry">
            <div class="grid-column-size"></div>

            @foreach($galleries as $gallery)
            <div class="masonry-brick gallery">
                <article class="gallery grid-item">
                    <div class="gallery-img-wrapper">
                        <a class="fancybox" href="{{ '/upload/full/'.$gallery->file_id.'.'.$gallery->extension  }}">
                            <img src="{{ '/upload/medium/'.$gallery->file_id.'.'.$gallery->extension  }}" alt="{{$gallery->seo->meta}}">
                        </a>
                    </div>
                </article>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endif