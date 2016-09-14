@extends("frontend.layout.master")
@section("meta")
    @if(isset($siteOptions))
        <title>{{!isset($siteOptions['name']) ? '' : $siteOptions['name']}}</title>
        <meta name="keywords" content="{{!isset($siteOptions['keyword']) ? '' :$siteOptions['keyword']}}">
        <meta name="description" content="{{!isset($siteOptions['description']) ? '' : $siteOptions['description']}}">
        <meta name="copyright" content="{{!isset($siteOptions['copyright']) ? '' : $siteOptions['copyright']}}">
        <meta name="author" content="{{!isset($siteOptions['author']) ? 'GobyArt' : $siteOptions['author']}}">
    @endif
@endsection
@section("content")
        <div id="map-canvas">
        </div>
        <div class="full-width bg-grey">
            <div class="content">
                <div class="headbox evenpadding">
                    @if (!session('messages'))
                    <div class="contact-controls clear-fix">
                        <ul class="error-message">
                            @foreach($errors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                        {!! Form::open(array('action' => 'FrontEnd\ContactController@create')) !!}
                        <div class="col col1 text-left">
                            {!! Form::text('contact_name', null,
                                array('required',
                                      'class'=>'',
                                      'placeholder'=>'Họ Và Tên')) !!}
                            {!! Form::text('contact_phone', null,
                               array('required',
                                     'class'=>'',
                                     'placeholder'=>'Số điện thoại')) !!}
                            {!! Form::text('contact_email', null,
                               array('required',
                                     'class'=>'',
                                     'placeholder'=>'Địa chỉ Email')) !!}

                            <div class="text-right">
                                {!! Form::submit('Gửi',
                                       array('class'=>'btn btn-inverted btn-round text-uppercase')) !!}
                            </div>
                        </div>
                        <div class="col col2 text-left">
                            {!! Form::text('contact_title', null,
                              array('required',
                                    'class'=>'',
                                    'placeholder'=>'Tiêu Đề')) !!}
                            {!! Form::textarea('contact_content', null,
                               array('',
                                     'class'=>'form-control',
                                     'placeholder'=>'Nội Dung ')) !!}
                        </div>
                        {!! Form::close() !!}
                        {{--<div class="col col1 text-left">--}}

                            {{--<input type="text" name="customer_name" placeholder="Họ Và Tên" >--}}
                            {{--<input type="text" name="event_name" placeholder="Số điện thoại" >--}}
                            {{--<input type="text" name="email" placeholder="Địa chỉ Email">--}}
                            {{--<div class="text-right">--}}
                                {{--<a href="" class="btn btn-inverted btn-round text-uppercase">Gửi</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col col2 text-left">--}}
                            {{--<input type="text" name="title" placeholder="Tiêu Đề">--}}
                            {{--<textarea name="content" placeholder="Nội Dung"></textarea>--}}
                        {{--</div>--}}

                    </div>
                    @else
                        <div class="contact-message">{{ session('messages') }}</div>
                    @endif
                </div>
            </div>
        </div>
@endsection
@section("scripts")
            <script type="text/javascript">
                var map;
                function initMap(){
                    var locations = [
                        ['{{ $siteOptions['name'] }}', "{{ preg_replace( "/\r|\n/", "",  $siteOptions['description']) }}", '{{ $siteOptions['phone'] }}',
                           '{{ $siteOptions['email_address'] }}', '{{ $siteOptions['url'] }}', '{{ $siteOptions['location_longitude'] }}','{{ $siteOptions['location_latitude'] }}',
                            'https://mapbuildr.com/assets/img/markers/default.png']
                    ];

                    var mapOptions = {
                        center: new google.maps.LatLng({{ $siteOptions['location_longitude'] }}, {{  $siteOptions['location_latitude']  }}),
                        zoom: 16,
                        zoomControl: true,
                        zoomControlOptions: {
                            style: google.maps.ZoomControlStyle.SMALL,
                        },
                        disableDoubleClickZoom: true,
                        mapTypeControl: false,
                        scaleControl: false,
                        scrollwheel: false,
                        panControl: false,
                        streetViewControl: false,
                        draggable: true,
                        overviewMapControl: false,
                        overviewMapControlOptions: {
                            opened: false,
                        }
                    }
                    map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
                    for (i = 0; i < locations.length; i++) {
                        if (locations[i][1] =='undefined'){ description ='';} else { description = locations[i][1];}
                        if (locations[i][2] =='undefined'){ telephone ='';} else { telephone = locations[i][2];}
                        if (locations[i][3] =='undefined'){ email ='';} else { email = locations[i][3];}
                        if (locations[i][4] =='undefined'){ web ='';} else { web = locations[i][4];}
                        if (locations[i][7] =='undefined'){ markericon ='';} else { markericon = locations[i][7];}
                        marker = new google.maps.Marker({
                            icon: markericon,
                            position: new google.maps.LatLng(locations[i][5], locations[i][6]),
                            map: map,
                            title: locations[i][0],
                            desc: description,
                            tel: telephone,
                            email: email,
                            web: web
                        });
                        if (web.substring(0, 7) != "http://") {
                            link = "http://" + web;
                        } else {
                            link = web;
                        }
                        ContactPage.bindInfoWindow(marker, map, locations[i][0], description, telephone, email, web, link);
                    }
                }

                $(function () {
                    ContactPage.initPage();
                })

            </script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMWvrZkeLRrGTqh9RgY7niHemli1HIPDU&callback=initMap"
                    type="text/javascript"></script>

@endsection