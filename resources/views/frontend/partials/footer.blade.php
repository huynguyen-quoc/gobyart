<div class="footer parallax full-width" style="background-position: 50% 200px;">
    <div class="footer-inner">
        <div class="content col_padding_bottom">
            <!-- Head -->
            <div class="headbox">
                <span class="footer-logo left gobyIcon goby-GB"></span>
                <div class="socialbookmark-container">
                    <div class="socialbookmark-row">
                        <a href="https://www.facebook.com/ICE-Models-Germany-872495876166889/" target="_blank" class="social-bookmark"><span class="gobyArtIcon">O</span></a>
                    </div>
                    {{--<div class="socialbookmark-row">--}}
                        {{--<a href="https://vimeo.com/icegermany" target="_blank" class="social-bookmark"><span class="gobyArtIcon">Q</span></a>--}}
                        {{--<a href="https://icegermany.wordpress.com" target="_blank" class="social-bookmark"><span class="gobyArtIcon">V</span></a>--}}
                    {{--</div>--}}
                </div>
            </div>
            <!-- End Head -->
            <hr class="white-bd white-fg">
            <!-- 3 Col -->
            <div class="col col3_1 text_left">
                @if(isset($siteOptions))
                    {!! !isset($siteOptions['about_footer']) ? html_entity_decode('') : html_entity_decode($siteOptions['about_footer']) !!}
                @endif
            </div>

            <hr class="white l_hidden ">

            <div class="col col3_2 text_left">
                {{--<p><b>ICE models germany gbr</b><br>Hopfensack 19<br>D-20457 Hamburg<br><br><a href="mailto:info@icemodels.de">info@icemodels.de</a></p>--}}
                @if(isset($siteOptions))
                    {!! !isset($siteOptions['address_footer']) ? html_entity_decode('') : html_entity_decode($siteOptions['address_footer']) !!}
                @endif
            </div>


            <div class="col col3_3 text_left">
                <br class="l_hidden">
                <p>Phone<br>
                    @if(isset($siteOptions))
                        {!! !isset($siteOptions['phone']) ? html_entity_decode('') : html_entity_decode($siteOptions['phone']) !!}
                    @endif
                </p>
                <hr class="white l_hidden">
                <p style="opacity: 0.9">
                    <br class="s_hidden m_hidden">
                    © 2016 GOBY ART
                </p>

            </div>
            <!-- End 3 Col -->
        </div>
    </div>
</div>