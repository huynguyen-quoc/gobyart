@extends('layouts.main')

@section('content')
    <!-- Main Content -->
    <section class="content-wrap">
        <!-- Breadcrumb -->
        <div class="page-title">

            <div class="row">
                <div class="col s12 m9 l10">
                    <h1>Vị Trí</h1>
                </div>
            </div>

        </div>
        <!-- /Breadcrumb -->
        <div class="card-panel m-t-50">
            <form id="form-map-location" data-parsley-trigger="keyup">
                <div class="row">
                    <div class="col l4 m12 s12">
                        <div class="input-field">
                            <input id="map-location-search" type="text">
                            <label for="map-location-search">{{ trans('client_input.map_search') }}</label>
                        </div>
                    </div>
                    <div class="col l4 m12 s12">
                        <div class="input-field">
                            <input id="map-longitude" type="text" data-parsley-pattern="^[0-9]*\.[0-9]{14}$" name="location_longitude"
                                   value="{{ isset($longitude) ?  $longitude->value: 0 }}">
                            <label for="map-longitude">{{ trans('client_input.longitude') }}</label>
                        </div>
                    </div>
                    <div class="col l4 m12 s12">
                        <div class="input-field">
                            <input id="map-latitude" type="text" data-parsley-pattern="^[0-9]*\.[0-9]{14}$"
                                   value="{{ isset($latitude) ?  $latitude->value: 0 }}" name="location_latitude">
                            <label for="map-latitude">{{ trans('client_input.latitude') }}</label>
                        </div>
                    </div>
                    <div class="col l12 m12 s12">
                        <div class="map" id="map-location"></div>
                    </div>
                </div>
            </form>
        </div>

    </section>
    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a class="btn-floating btn-large red modal-trigger tooltipped"  data-position="top" data-delay="50" data-tooltip="{{ trans('client_title.tool_tip_change_location') }}" href="#modal-confirm">
            <i class="mdi mdi-editor-mode-edit"></i>
        </a>
    </div>
    <div id="modal-confirm" class="modal w-30-p">
        <div class="modal-content">
            <h4>{{ trans('client_title.confirm_title') }}</h4>
            <p>{{ trans('client_title.confirm_detail_edit') }}</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action waves-effect waves-red btn-flat" id="confirm_change">{{ trans('client_button.yes') }}</a>
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">{{ trans('client_button.no') }}</a>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Google Maps API -->
    <script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMWvrZkeLRrGTqh9RgY7niHemli1HIPDU" type="text/javascript"></script>
    <script type="text/javascript" src="/assets/bower_components/gmaps/gmaps.min.js"></script>
    <!--suppress JSUnresolvedFunction -->
    <script type="text/javascript">
        $(function(){
            "use strict";

            $(function(){
               window.conApp.hideSpin();
                // init map
                var map = new GMaps({
                    div: '#map-location',
                    lat: "{{ isset($latitude) ?  $latitude->value : 0 }}",
                    lng: "{{ isset($longitude) ? $longitude->value : 0 }}",
                    zoom: 13
                });

                var handleEvent = function(event) {
                    document.getElementById('map-latitude').value = event.latLng.lat();
                    document.getElementById('map-longitude').value = event.latLng.lng();
                };

                // add  marker
                var marker = map.addMarker({
                    lat: "{{ isset($latitude) ?  $latitude->value: 0 }}",
                    lng: "{{ isset($longitude) ? $longitude->value: 0 }}",
                    draggable: true
                });

                marker.addListener('drag', handleEvent);
                marker.addListener('dragend', handleEvent);

                // redraw map on search
                var redrawMap = function(address) {
                    marker.setMap(null);
                    GMaps.geocode({
                        address: address,
                        callback: function(results, status) {
                            if (status == 'OK') {
                                var pos = results[0].geometry.location;
                                map.setCenter(pos.lat(), pos.lng());
                                marker =  map.addMarker({
                                    lat: pos.lat(),
                                    lng: pos.lng(),
                                    draggable: true
                                });
                                marker.addListener('drag', handleEvent);
                                marker.addListener('dragend', handleEvent);
                            }
                        }
                    });
                };
                var updateLocation = function(lat, lng) {
                    lat = lat ? lat : 0;
                    lng = lng ? lng : 0;
                    marker.setMap(null);
                    map.setCenter(lat, lng);
                    marker = map.addMarker({
                        lat: lat,
                        lng: lng,
                        draggable: true
                    });
                    marker.addListener('drag', handleEvent);
                    marker.addListener('dragend', handleEvent);
                };


                // search event
                var searchTimeout;
                $('#map-location-search').on('keyup', function(e) {
                    e.preventDefault();
                    clearTimeout(searchTimeout);

                    (function(address) {
                        searchTimeout = setTimeout(function() {
                            redrawMap(address);
                        }, 400);
                    }($(this).val().trim()));
                });

                $('#form-map-location').parsley();
                $('#map-latitude,#map-longitude').on('change', function(e){
                    var lng = $('#map-longitude').val();
                    var lat = $('#map-latitude').val();
                    updateLocation(lat, lng)
                });

                $('#confirm_change').on('click', function(e){
                    e.preventDefault();
                    $('#modal-confirm').closeModal();
                    var request = {
                        method : 'PUT',
                        data : $('#form-map-location').serializeObject(),
                        url : '/api/site-config/site_location',
                        success : function(response){
                            console.log(response)
                            var $toastContent = $('<span>{{ trans('client_title.location_change_success') }}</span>');
                            Materialize.toast($toastContent, 5000);
                        },
                        error : function(error){
                            var error = error.responseJSON;
                            var $toastContent = $('<span>' + error +'</span>');
                            Materialize.toast($toastContent, 5000);
                        }
                    }
                    window.conApp.ajaxCall(request);

                });

            });
        }(jQuery));
    </script>
@endsection