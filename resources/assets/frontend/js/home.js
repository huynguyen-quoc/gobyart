/**
 * Created by huynguyen on 8/26/16.
 */

var HomePage = function(){

    var initPage = function(youtube){
        $('body').toggleClass('home');
        $('.loader-container').toggleClass("active");
        $('.grid-masonry').toggleClass("active");
        $('.partner-slideshow-wrapper').toggleClass('hidden-data');
        scrollParallaxHomeImage();$(window).scroll (function() {scrollParallaxHomeImage();});
        $('#title-video').html('<iframe  src="https://www.youtube.com/embed/' + youtube+ '?autoplay=1&controls=0&modestbranding=1&loop=1&playlist=' + youtube
            +'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>').fitVids();
        initSlider();
        initGrid();
        initCheckBox();
    };

    var scrollParallaxHomeImage = function(){
        var el=$('#home-spacer-image');
        var speed=0.75
        var bgPositionOffsetY = 0;
        var newPositionY=bgPositionOffsetY;
        if(el.length>0){
            if(window.parallaxScrollEnabled){
                var windowHeight=$(window).height();
                var top = el.offset().top;
                var scrollY = $(window).scrollTop();
                if( scrollY + windowHeight + 100 > top && top - windowHeight - 100 < scrollY){
                    distance = scrollY - top;
                    newPositionY=(bgPositionOffsetY - distance * speed)+"px";
                }
            }
            elBackgrounPos = "50% " + newPositionY;
            el.css({backgroundPosition: elBackgrounPos});
        }
    };

    var initCheckBox = function(){
        $('input[name=iCheck]').iCheck({
            checkboxClass: 'iradio_square-pink artist-check',
            radioClass: 'iradio_flat-pink',
            uncheckedClass: 'test',
            increaseArea: '20%' // optional
        });
        $("#filter_btn").on('click' , function(e){
            e.preventDefault();
            e.stopPropagation();
            var data = $.map($('input[name="iCheck"]:checked'), function(item, index){
                return $(item).val();
            });
            if(data.length <= 0) return;
            window.location.href='/danh-sach-nghe-si/' + data.join('_') + '/tat-ca';
        });
    };

    var initGrid = function(){
        $('.grid-masonry').masonry({
            columnWidth: '.grid-column-size',
            itemSelector: '.masonry-brick',
            percentPosition: true
        });

    };

    var initSlider = function(){
        $("#partner-slideshow").slick({
            slidesToScroll: 5,
            variableWidth: true,
            autoPlay: true,
            infinite: true,
            arrows: true,
            dots : false,
            responsive: [
                {
                    breakpoint: 850,
                    settings:{
                        slidesToScroll: 3
                    }
                }
                ,{
                    breakpoint: 640,
                    settings:{
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }





    return {
        initPage : initPage
    }
}();