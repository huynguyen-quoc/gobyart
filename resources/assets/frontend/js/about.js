/**
 * Created by huynguyen on 8/20/16.
 */

var AboutPage = function(){

    var initPage = function(totalGrid){
        $('body').toggleClass('about');
        $('.loader-container').toggleClass("active");
        $('.grid-masonry').toggleClass("active");
        scrollParallaxAboutImage();$(window).scroll (function() {scrollParallaxAboutImage();});
        initGrid();
    };

    var scrollParallaxAboutImage = function(){
        var el=$('#about-spacer-image');
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
    }

    var initGrid = function(totalGrid){
        var $grid = $('.team-masonry').masonry({
            columnWidth: '.grid-column-size',
            itemSelector: '.masonry-brick',
            percentPosition: true
        });

        var $grid2 = $('.event-masonry').masonry({
            columnWidth: '.grid-column-size',
            itemSelector: '.masonry-brick',
            percentPosition: true
        });

        $grid2.imagesLoaded(function () {
            $grid2.masonry('layout');
        });

        $(".fancybox").attr('rel', 'gallery')
            .fancybox({
                arrows : false,
                closeBtn : false,
                scrolling : 'no',
                nextEffect : 'fade',
                prevEffect : 'fade',
                beforeShow: function() {
                    var $this = $(this.wrap);
                    if($this){
                        if($this.siblings('.fancybox-model-controller').length > 0) return;
                        var temp = '<a class="fancybox-model-controller fancybox-model-close" ><span class="gobyArtIcon">D</span></a>' +
                            '<div class="fancybox-model-wrapper ">' +
                            '<a class="fancybox-model-controller fancybox-model-previous"> ' +
                            '<span class="gobyArtIcon">J</span></a> ' +
                            '<a class="fancybox-model-controller fancybox-model-next">' +
                            '<span class="gobyArtIcon">K</span></a>' +
                            '</div>';
                        $(temp).prependTo($this.parent());
                        $this.parent().on('click', '.fancybox-model-previous', function(){
                            $.fancybox.prev()
                        });
                        $this.parent().on('click', '.fancybox-model-next', function(){
                            $.fancybox.next()
                        });
                        $this.parent().on('click', '.fancybox-model-close', function(){
                            $.fancybox.close()
                        })
                    }
                },
                beforeClose: function () {
                    var $this = $(this.wrap);
                    console.log('ok');
                    if($this){
                        $('.fancybox-model-wrapper', $this.parent()).remove();
                        $('.fancybox-model-controller', $this.parent()).remove();
                    }
                }
            });
    };



    return {
        initPage : initPage
    }
}();