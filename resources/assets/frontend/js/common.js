/**
 * Created by huynguyen on 8/20/16.
 */
var parallaxScrollEnabled=true;
if( $(window).width() < 800 || navigator.userAgent.match(/(iPod|iPhone|iPad)/) ){
    parallaxScrollEnabled=false;
}
window.hidePopover = function(event){
    window.clearTimeout(window.showPopoverTimeout);
    $('#model-image-popover').fadeOut(100);
};
(function($){



    if (window.parallaxScrollEnabled==false) {
        $(".parallax").addClass("background-attachment-scroll");
    }

    $(document).on('touchstart', function(event) {
        if(event.type=='touchstart'){
            $('html').removeClass('is-not-touch');
            $('html').addClass('is-touch');
            $(document).off('touchstart');
        }
    });

    var addToCart = function(e){
        e.preventDefault();
        var $this = $(this);
        $this.toggleClass('loading');
        $this.off('click');
        var artist = $this.closest('article').data('artist');
        var words = CryptoJS.enc.Base64.parse(artist);
        var textString = CryptoJS.enc.Utf8.stringify(words);
        var json = JSON.parse(textString);
        $.ajax({
            url : '/cart',
            type:"POST",
            contentType:"application/json; charset=utf-8",
            dataType:"json",
            data: JSON.stringify({ artist_id : json['artist_id'], full_name : json['full_name']}),
            success: function(data){
                $this.toggleClass('loading');
                var cart = $('.shopping-cart:visible');
                var dragItem = $this.find(".not-in-wishlist .button-loading");
                $this.on('click', removeFromCard);
                $this.closest('.model').toggleClass('wishlist');
                var count = data['total_cart'];
                $('.wishlist-counter').text(count);
                if (dragItem) {
                    // var width = $this.width();
                    // var height =$this.height();
                    // var dragItemClone = dragItem.clone()
                    //     .css({
                    //         'position': 'absolute',
                    //         'display': 'block',
                    //         'z-index' : 9999
                    //     })
                    //     .appendTo($('body'))
                    //     .offset({
                    //         top: dragItem.parent().offset().top + height / 2,
                    //         left: dragItem.parent().offset().left + width / 2
                    //     })
                    //     .animate({
                    //         'top': cart.offset().top + 10,
                    //         'left': cart.offset().left + 10,
                    //     }, 1000);
                    //
                    // dragItemClone.animate({
                    //     'width': 0,
                    //     'height': 0
                    // }, function () {
                    //     var count = data['total_cart'];
                    //     $('.wishlist-counter').text(count);
                    //     $(this).detach()
                    // });
                }
            },error : function(){
                $this.toggleClass('loading');
                $this.on('click', addToCart);
            }
        });
    };
    var removeFromCard = function(e){
        e.preventDefault();
        var $this = $(this);
        var $body = $('body');
        $this.toggleClass('loading');
        $this.off('click');
        var artist = $this.closest('article').data('artist');
        var words = CryptoJS.enc.Base64.parse(artist);
        var textString = CryptoJS.enc.Utf8.stringify(words);
        $.ajax({
            url : '/cart/' + JSON.parse(textString).artist_id,
            type:"DELETE",
            contentType:"application/json; charset=utf-8",
            dataType:"json",
            success: function(data){
                $this.toggleClass('loading');
                var count = data['total_cart'];
                $('.wishlist-counter').text(count);
                window.hidePopover();
                if(!$body.hasClass('wishlist')) {
                    $this.on('click', addToCart);
                    $this.closest('.model').toggleClass('wishlist');
                }else{
                    var $item = $this.closest('.masonry-brick');
                    var $grid = $('.grid-masonry');
                    $grid.masonry( 'remove', [$item[0]]).masonry('layout');;


                }
            },error : function(){
                $this.toggleClass('loading');
                $this.on('click', removeFromCard);
            }
        });
    };

    var deactiveItemsInParentTouchItemScope = function(el){
        if($('html').hasClass('is-touch')){
            $(el).closest('.touch-item-wrapper').find('.active-touch').removeClass('active-touch');
        }
    };

    $(function(){
            //$(".navi_mobile").slideToggle(200);
            $(".navi_mobile").on('touchmove', function(e) {
                e.preventDefault();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // HEAD ROOM
            var header = document.querySelector("#header");
            if(header!= undefined){
                new Headroom(header, {
                    tolerance: {
                        down : 2,
                        up : 5
                    },
                    offset : 450,
                    classes: {
                        initial: "slide--top",
                        pinned: "slide--reset",
                        unpinned: "slide--up",
                        top : "slide--top",
                        notTop : "slide--not-top"
                    },
                    onUnpin:function(){
                        if(this.lastKnownScrollY<=this.offset*3){
                            $(this.elem).addClass('slide--up-from-top');
                        }
                    },
                    onPin:function(){
                        $(this.elem).removeClass('slide--up-from-top');
                    }
                }).init();
            }
            $('.model:not(.wishlist) .wishlist-toggle-wrapper').on('click', addToCart);
            $('.model.wishlist .wishlist-toggle-wrapper').on('click', removeFromCard);
            $('.model a').on('click touchstart', function(event){
                var $html = $('html');
                var $this = $(this);
                if($html.hasClass('is-touch')){
                    //if(event.type=='click'){
                        var item= $this.closest('.touch-item');
                        if(item.length){
                            if(item.hasClass('active-touch')){
                                return true;
                            }
                            else{
                                event.stopPropagation();
                                event.preventDefault();
                                event.stopNextHandler=true;
                                deactiveItemsInParentTouchItemScope(item);
                                item.addClass('active-touch');
                                return false;
                            }
                        }
                    //}
                }
            });
            $('.navigation-toggle,.navi-toggle').on('click', function(e){
                $(".navi_mobile").slideToggle(200);
            });


    });


})(window.jQuery);