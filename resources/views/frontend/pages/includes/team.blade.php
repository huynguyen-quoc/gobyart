<div class="full-width bg-white">
    <div class="content">
        <div class="headbox">
            <span class="text_left text-uppercase">GOBY ART TEAM</span>
        </div>

        <hr class="divider">
        <div id="team-loader" class="loader-container active" >
            <div class="content">
                <div class="gobyArtIcon spinner">S</div>
                <div class="icon-label">Đang Tải</div>
            </div>
        </div>
        <div class="grid-masonry team-masonry" >
            <div class="grid-column-size"></div>
            @foreach($teams as $team)
                <div class="masonry-brick">
                    <article class="team grid-item">
                        <a href="#" >
                            <div class="team-img-wrapper team-background-img-wrapper"
                                 style="background-image: url({{ '/upload/full/'.$team->avatar->file_id.'.'.$team->avatar->extension  }})">
                                <div class="team-name-box">
                                    <span class="team-name" data-name="{{ $team->name }}"></span>
                                </div>
                            </div>
                        </a>
                        <div class="team-name-wrapper">
                            <a href="#">
                            <span class="team-name ">
                              {{ $team->name }}
                            </span>
                            </a>
                        </div>
                    </article>
                </div>
            @endforeach

        </div>
    </div>
</div>
