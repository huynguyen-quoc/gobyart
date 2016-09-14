
<div class="full-width bg-white col_padding_bottom">
    <div class="content scroll">
        <div class="headbox">
            <span class="text_left text-uppercase">Nghệ Sĩ GobyArt</span>
        </div>
        <hr class="divider">
        @if(isset($artists) && count($artists) > 0)
        <div class="loader-container active" >
            <div class="content">
                <div class="gobyArtIcon spinner">S</div>
                <div class="icon-label">Đang Tải</div>
            </div>
        </div>
        <div class="grid-masonry grid-model-list touch-item-wrapper">
            <div class="grid-column-size"></div>
            @foreach($artists as $artist)
                <div class="masonry-brick touch-item">
                    <article class="model grid-item  touch-item {{ $artist->added_cart ? 'wishlist' : '' }}" data-artist="{{ base64_encode(json_encode($artist)) }}">
                        <a href="/nghe-si/{{ $artist->slug }}"  >
                            <div class="model-img-wrapper model-background-img-wrapper"
                                 style="background-image: url({{'/upload/medium/'.$artist->avatar->file_id.'.'.$artist->avatar->extension }})">
                                <div class="model-name-box">
                                    <span class="model-name" data-name="{{ $artist->full_name }}"></span>
                                </div>

                                <div class="wishlist-icon-wrapper in-wishlist" >
                                    <div class="">
                                        {{--<span class="model-is-active gobyArtIcon">D</span>--}}
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
            @if($totalPage > 1)
            <div class="text-center">
                <a id="loading-more-btn" class="button-more">
                    <span class="gobyArtIcon medium">F</span><br>Xem Thêm
                </a>
            </div>

            <nav id="pagination" class="infinite-scroll-paging">
            @for($i = 1; $i <= $totalPage; $i++)
                <p><a href="{{ Request::url().'?page='.$i }}">Page {{ $i + 1}}</a></p>
            @endfor
            </nav>
            @endif
        @else
            <div >
                <div><br>Không tìm thấy kết quả!</div>
            </div>
            <div class="grid-masonry  grid-model-list">
            </div>
        @endif
    </div>

</div>

