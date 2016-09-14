@if(isset($image) && count($image)> 0)
<div class="full-width bg-white col_padding_bottom">

    <div class="content">
        <div class="loader-container active" >
            <div class="content">
                <div class="gobyArtIcon spinner">S</div>
                <div class="icon-label">Đang Tải</div>
            </div>
        </div>
        <div class="grid-masonry grid-model-list ">
            <div class="grid-column-size"></div>
            @foreach($image as $file)
                {{--@if($file['file_group_type'] == 'ARTIST_IMAGE_TYPE')--}}
                    <div class="masonry-brick">
                        <article class="image grid-item">
                            <div class="model-img-wrapper">
                                <a class="fancybox" href="{{'/upload/full/'.$file->file_id.'.'.$file->extension }}">
                                    <img alt="{{$file->original_name}}" src="{{'/upload/medium/'.$file->file_id.'.'.$file->extension}}"  >
                                </a>
                            </div>
                        </article>
                    </div>
                {{--@endif--}}
            @endforeach

        </div>
    </div>
    <div class="text-center">
        <a class="button-more" href="/models">
            <span class="gobyArtIcon medium">F</span><br>Xem Thêm
    </a>
    </div>
</div>
@endif