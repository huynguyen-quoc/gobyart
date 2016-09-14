/**
 * Created by huynguyen on 8/20/16.
 */

var ContactPage = function(){

    var initPage = function(){
        $('body').toggleClass('contact');

        initGrid();
    };

    var initGrid = function(){


        $('.grid-masonry').masonry({
            columnWidth: '.grid-column-size',
            itemSelector: '.masonry-brick',
            percentPosition: true
        });


    };

    var bindInfoWindow = function(marker, map, title, desc, telephone, email, web, link){
            var infoWindowVisible = (function () {
                var currentlyVisible = false;
                return function (visible) {
                    if (visible !== undefined) {
                        currentlyVisible = visible;
                    }
                    return currentlyVisible;
                };
            }());
            iw = new google.maps.InfoWindow();
            google.maps.event.addListener(marker, 'click', function() {
                if (infoWindowVisible()) {
                    iw.close();
                    infoWindowVisible(false);
                } else {
                    var html= "<div class='infoWindow'><h4>"+title+"</h4><p>"+desc+"<p><p>"+telephone+"<p><a href='mailto:"+email+"' >"+email+"<a><br/><a href='"+link+"'' >"+web+"<a></div>";
                    iw = new google.maps.InfoWindow({content:html});
                    iw.open(map,marker);
                    infoWindowVisible(true);
                }
            });
            google.maps.event.addListener(iw, 'closeclick', function () {
                infoWindowVisible(false);
            });
    }



    return {
        initPage : initPage,
        bindInfoWindow : bindInfoWindow
    }
}();