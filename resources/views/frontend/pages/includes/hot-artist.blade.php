<div class="full-width bg-white">
    <div class="content">
        <div class="headbox">
            <span class="text_left text-uppercase">Nghệ Sĩ Tiêu Biểu</span>
        </div>
        <div class="loader-container active" >
            <div class="content">
                <div class="gobyArtIcon spinner">S</div>
                <div class="icon-label">Đang Tải</div>
            </div>
        </div>
        <hr class="divider">
        <div class="grid-masonry touch-item-wrapper">

            <div class="grid-column-size"></div>
                @foreach($hotArtists as $artist)
                    <div class="masonry-brick">
                        <article class="model grid-item  touch-item {{ $artist->added_cart ? 'wishlist' : '' }} " data-artist="{{ base64_encode(json_encode($artist)) }}">
                            <a href="/nghe-si/{{ $artist->slug }}"  >
                                <div class="model-img-wrapper model-background-img-wrapper"
                                     style="background-image: url({{ isset($artist->avatar) ? '/upload/full/'.$artist->avatar->file_id.'.'.$artist->avatar->extension  : ''}})">
                                    <div class="model-name-box">
                                        <span class="model-name" data-name="{{ $artist->full_name }}"></span>
                                    </div>

                                    <div class="wishlist-icon-wrapper in-wishlist" >
                                        <div class="">
                                            <span class="gobyArtIcon">S</span>
                                        </div>
                                    </div>

                                    <div class="wishlist-toggle-wrapper">
                                        <div class="in-wishlist">
                                            <span class="icon-label s_hidden">Shortlist remove</span>
                                            <span class="icon-label l_hidden m_hidden">Shortlist -</span>
                                            <span class="button-loading">Adding to cart...</span>
                                        </div>
                                        <div class="not-in-wishlist">
                                            <span class="icon-label s_hidden">Add to shortlist</span>
                                            <span class="icon-label l_hidden m_hidden">Shortlist +</span>
                                            <span class="button-loading">Adding to cart...</span>
                                        </div>
                                    </div>

                                </div>
                            </a>
                            <div class="model-name-wrapper">
                                <a href="#">
                                    <span class="model-name ">
                                    {{ $artist['artist_full_name'] }}
                                    </span>
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach


        </div>
    </div>
    <div class="text-center">
        <a class="button-more" href="/danh-sach-nghe-si/tat-ca/tat-ca">
            <span class="gobyArtIcon medium">F</span><br>Xem Tất Cả
        </a>
    </div>
</div>
