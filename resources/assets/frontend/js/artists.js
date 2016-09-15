/**
 * Created by huynguyen on 8/20/16.
 */

var ArtistPage = function(){

    var initPage = function(totalGrid){
        $('body').toggleClass('artists');
        $('.loader-container').toggleClass("active");
        $('.grid-masonry').toggleClass("active");
        initGrid(totalGrid);
        initAddCart();
    };

    var initGrid = function(totalGrid){

        var $grid = $('.grid-masonry').masonry({
            columnWidth: '.grid-column-size',
            itemSelector: '.masonry-brick',
            percentPosition: true
        });

        var infiniteScroll = $('.grid-masonry').infinitescroll({
                navSelector  : "#pagination",
                // selector for the paged navigation (it will be hidden)
                nextSelector : "#pagination p a",
                // selector for the NEXT link (to page 2)
                itemSelector : ".grid-masonry .masonry-brick",
                dataType : 'json',
                loading: {
                    finished:  function(opts){
                        $('#loading-more-btn').html(' <span class="gobyArtIcon medium">F</span><br>Xem Thêm</a>');
                    },
                    finishedMsg: '',
                    img: undefined,
                    msg: undefined,
                    msgText :'',
                    selector: null,
                    speed: 'fast',
                    start:  function(opts){
                        if(totalGrid <= opts.state.currPage) return;
                        $('#loading-more-btn').html('<span class="gobyArtIcon medium">F</span><br>Đang Tải...</a>');
                        var  path = opts.path;
                        opts.state.currPage++;
                        var  desturl = (typeof path === 'function') ? path(opts.state.currPage - 1) : path.join(opts.state.currPage - 1);

                        $.ajax({
                            dataType: 'json',
                            type: 'GET',
                            url: desturl,
                            success: function (data, textStatus, jqXHR) {
                                opts.loading.finished.call($(opts.contentSelector)[0],opts);
                                opts.state.isDuringAjax = false;
                                if(data.total_page >= opts.state.currPage) {
                                    opts.state.isDone = true;
                                    $('#loading-more-btn span').remove();
                                }
                                opts.callback($(opts.contentSelector)[0],data,desturl);
                            },
                            error: function() {
                            }
                        });
                    }
                },
                appendCallback: false,
                path : function(currentPageNumber){
                    return (window.location.href+'?page=' + currentPageNumber);
                }
            },
            // Function called once the elements are retrieved
            function(data) {
                var artists =  data.artists;
                // var temps = [];
                var artistDetails = kendo.template($("#artistDetail").html());
                var pagingNumbers =  artistDetails(artists);
                // $.each(artists, function(index, artist){
                //     var url = artist.image_url;
                //     var data = JSON.stringify(artist);
                //     var wordArray = CryptoJS.enc.Utf8.parse(data);
                //     var base64 = CryptoJS.enc.Base64.stringify(wordArray);
                //
                //     var template = "<div class='masonry-brick'> <article class='model grid-item' data-artist='" + base64 + "'>" +
                //         "<a href='/nghe-si' > " +
                //         "<div class='model-img-wrapper model-background-img-wrapper' style='background-image: url(" + url + ")'>" +
                //         "<div class='model-name-box'> <span class='model-name' data-name='" + artist.full_name + "'></span> </div>" +
                //         "<div class='wishlist-icon-wrapper in-wishlist' > <div class=''>" +
                //         "<span class='model-is-active gobyArtIcon'>D</span> <span class='gobyArtIcon'>S</span> </div> </div>" +
                //         "<div class='wishlist-toggle-wrapper'> <div class='in-wishlist'> " +
                //         "<span class='icon-label s_hidden'>Shortlist remove</span> " +
                //         "<span class='icon-label l_hidden m_hidden'>Shortlist </span> " +
                //         "<span class='sofaIcon l_hidden m_hidden'>D</span> " +
                //         "</div>" +
                //         "<div class='not-in-wishlist'>" +
                //         "<span class='icon-label s_hidden'>Add to shortlist</span>" +
                //         " <span class='icon-label l_hidden m_hidden'>Shortlist +</span>" +
                //         "</div>" +
                //         "</div>" +
                //         "</div> </a> " +
                //         "<div class='model-name-wrapper'> <a href='#'> <span class='model-name'>" + artist.full_name + "</span> </a>"+
                //         "</div> </article> </div>";
                //     // $grid.append($.parseHTML(template));
                //     temps.push($.parseHTML(template)[0]);
                // });
                temps = $(pagingNumbers).css('opacity', 0);
                temps.animate({opacity: 1});
                $grid.append(temps);
                $grid.masonry('appended', temps);
            });

        $(".grid-masonry").on('mouseenter', '.grid-item',function(e){
            var $this = $(this);
            var artist = $this.data('artist');
            if(artist) {
                var words = CryptoJS.enc.Base64.parse(artist);
                var textString = CryptoJS.enc.Utf8.stringify(words);
                initImagePopover(e, JSON.parse(textString))
            }
        });
        $('.grid-masonry').hoverIntent({
            over: showPopover,
            out: hidePopover,
            selector: '.grid-item'
        });
    };

    var showPopover=function(event){
        var $html = $('html');
        if($html.hasClass('is-touch')) return false;
        window.clearTimeout(window.showPopoverTimeout);

        var targetEl=$(event.currentTarget);
        if(targetEl==undefined) return false;
        var targetElPosition=targetEl.offset();

        var top=targetElPosition.top;
        var left=targetElPosition.left;
        var height=targetEl.outerHeight();
        var width=targetEl.outerWidth();
        var padding=targetEl.parent().innerHeight()-height;

        var popupMainCss={
            top: top - padding,
            left: left - padding,
        };
        var popupInfoCss={
            top: 0,
            left: 0,
            width: width + 2 * padding,
            padding: padding
        };
        var modelInfoCss={
            marginTop: height + padding
        };
        var popupGridCss={
            top: 0,
            left: 'auto',
            right: 'auto',
            width:  popupInfoCss.width * 1.05,
            paddingTop: padding,
            paddingRight: 0,
            paddingBottom: 0,
            paddingLeft: 0,
            display: 'block'
        };
        var popupGridColumnCss={
            paddingRight: 0,
            paddingLeft: 0,
            marginBottom: padding
        };

        var offsetParent=$('body');
        var offsetParentWidth=offsetParent.innerWidth();

        var shadowCss={};
        if(left < (offsetParent.offset().left+offsetParentWidth/2)){
            // position on right
            popupGridCss.left=popupInfoCss.width;
            popupGridColumnCss.paddingRight=padding;
            $('#model-image-popover').removeClass("model-on-right").addClass("model-on-left").css(shadowCss);
        }
        else{
            // position on left
            popupGridCss.left=-popupGridCss.width;
            popupGridColumnCss.paddingLeft=padding;
            $('#model-image-popover').removeClass("model-on-left").addClass("model-on-right").css(shadowCss);

        }

        // apply css
        $('#model-image-popover').css(popupMainCss);
        $('#model-image-popover-info').css(popupInfoCss);
        $('#model-image-popover-info #model-info').css(modelInfoCss);
        $('#model-image-popover-grid').css(popupGridCss);
        $('#model-image-popover-grid .grid-model-image-popover-column').css(popupGridColumnCss);

        // change layer ordering
        targetEl.closest('.grid-masonry').find(".model").css({'z-index':0});
        targetEl.css({'z-index':29});

        window.showPopoverTimeout=window.setTimeout(function(){$('#model-image-popover').hide().fadeIn(100);}, 250);
    };

    var hidePopover = function(event){
        window.clearTimeout(window.showPopoverTimeout);
        $('#model-image-popover').fadeOut(100);
    };

    var initImagePopover=function(event, model){
        var information_data_1 = [
            { title: '', value : kendo.toString(kendo.parseDate(model.date_of_birth,'yyyy-MM-dd HH:mm:ss'), 'dd/MM/yyyy')}
        ];
        var information_data_2 = $.map(model.extra_information, function(item, index){
           return  { title: index, value : item}
        });
        $('#model-image-popover .model-info-model-name').html(model.full_name);
        $('#model-image-popover .model-type').html("(" + model.music_category.type.name + ")");
        $('#model-image-popover .model-info-col-1').empty();
        $('#model-image-popover .model-info-col-2').empty();
        var columnInfo = kendo.template($("#detailTemplate").html());
        var column1Html =  columnInfo(information_data_1);

        var column2Html =  columnInfo(information_data_2);
        // $.each(information_data_1 , function(){
        //     var template = '<div class="model-info-detail">' +
        //         '<span class="model-detail-label">' + this.title + '</span>' +
        //         '<span class="model-detail-value" >' + this.value + '</span>' +
        //         '</div>';
        //     information1Data += template;
        // });
        // $.each(information_data_2 , function(){
        //     var template = '<div class="model-info-detail">' +
        //         '<span class="model-detail-label">' + this.title + '</span>' +
        //         '<span class="model-detail-value" >' + this.value + '</span>' +
        //         '</div>';
        //     information2Data += template;
        // });
        $('#model-image-popover .model-info-col-1').html(column1Html);
        $('#model-image-popover .model-info-col-2').html(column2Html);

        $.ajax({
            url : '/api/image/preview/' + model.artist_id,
            type:"GET",
            contentType:"application/json; charset=utf-8",
            dataType:"json",
            success: function(data){
                $('#model-image-popover-grid .grid-model-image-popover .grid-model-image-popover-column').empty();
                if(data.length > 0){
                    var columnTemp = kendo.template($("#imagePopOverTemplate1").html());
                    var column1Html =  columnTemp(data);
                    // var template  =  '<div class="grid-item"> <img src="/upload/' + data[0].artist_type + '/' + data[0].artist_name + '/' + data[0].file_name + '"></div>';
                    // if(data.length > 1) {
                    //     template += '<div class="grid-item"> <img src="/upload/' +  data[1].artist_type+ '/' + data[1].artist_name + '/' +  data[1].file_name + '"></div>';
                    // }
                    $('#model-image-popover-grid .grid-model-image-popover .grid-model-image-popover-column.column-1').html(column1Html);
                    var columnTemp2 = kendo.template($("#imagePopOverTemplate2").html());
                    var column2Html =  columnTemp2(data);
                    $('#model-image-popover-grid .grid-model-image-popover .grid-model-image-popover-column.column-2').html(column2Html);
                }
            }
        });

        //   var requestId = model['artist_slug'] + "_" + Math.random();
//            if(requestId!=$scope.imagePopover.requestId){
//                $scope.imagePopover.images=$scope.defaultImagePopoverImageArray;
//            }
//            $scope.imagePopover.requestId=requestId;
//            $scope.imagePopover.isActive=true;
//            $scope.imagePopover.model=model;
//
//            ImageSet.server().get({imageTypeString:'preview',modelString:model.name},function(data){
//                if(data.$resolved && (!data.data!=undefined) && (requestId==$scope.imagePopover.requestId)){
//                    $scope.imagePopover.images=ImageSet.getImagesFromImageSet(data);
//                }
//            });
    };


    var initAddCart = function(){

    };


    return {
        initPage : initPage
    }
}();