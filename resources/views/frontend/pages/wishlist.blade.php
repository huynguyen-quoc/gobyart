@extends("frontend.layout.master")
@section("content")
        <div class="full-width bg-grey">
            <div class="content  ">
                <div class="headbox evenpadding">
                    @if (!session('messages'))
                        <div class="wishlist-controls clear-fix">
                            <ul class="error-message">
                                @foreach($errors as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                            {!! Form::open(array('action' => 'FrontEnd\WishListController@create')) !!}
                            <div class="col col1 text-left">
                                {!! Form::text('customer_name', null,
                                    array('required',
                                          'class'=>'',
                                          'placeholder'=>'Tên Khách Hàng')) !!}
                                {!! Form::text('event_name', null,
                                   array('required',
                                         'class'=>'',
                                         'placeholder'=>'Tên Sự Kiên')) !!}
                                {!! Form::text('email_address', null,
                                   array('required',
                                         'class'=>'',
                                         'placeholder'=>'Địa chỉ Email')) !!}
                                {!! Form::text('phone_number', null,
                                  array('required',
                                        'class'=>'',
                                        'placeholder'=>'Số điện thoại')) !!}
                                {!! Form::text('event_time', null,
                                   array('required',
                                         'class'=>'',
                                         'placeholder'=>'Thời Gian Tổ Chức')) !!}
                                {!! Form::text('event_location', null,
                                   array('required',
                                         'class'=>'',
                                         'placeholder'=>'Địa Điểm Tổ Chức')) !!}
                            </div>
                            <div class="col col2 text-left">
                                {!! Form::textarea('description', null,
                                   array('',
                                         'class'=>'form-control',
                                         'placeholder'=>'Thông Tin Thêm')) !!}
                                {!! Form::submit('Gửi',
                                         array('class'=>'btn btn-inverted btn-round text-uppercase')) !!}
                            </div>
                            {!! Form::close() !!}


                        </div>
                    @else
                        <div class="wishlist-message">{{ session('messages') }}</div>
                    @endif
                </div>
            </div>
        </div>
        @if(!session('messages'))
         @include("frontend.pages.includes.artist-wishlist")
        @endif
@endsection
@section("scripts")
    <script id="imagePopOverTemplate1" type="text/x-kendo-template">
        # if(data.length > 0){ #
        <div class="grid-item"> <img src="/upload/low/#= data[0].file_id + '.' + data[0].extension#"></div>
        # } #
        #  if(data.length > 1) { #
        <div class="grid-item"> <img src="/upload/low/#= data[1].file_id + '.' + data[1].extension#"></div>
        #} #
    </script>
    <script id="detailTemplate" type="text/x-kendo-template">
        # for(var i =0; i< data.length ; i++ ){ #
        <div class="model-info-detail">
            # if(data[i].title !== '' && data[i].value !== ''){ #
            <span class="model-detail-label">#=data[i].title#</span>
            # } #
            # if(data[i].value !== ''){ #
            <span class="model-detail-value" >#=data[i].value#</span>
            # } #

        </div>
        # } #
    </script>
    <script id="imagePopOverTemplate2" type="text/x-kendo-template">
        # if(data.length > 2){ #
        <div class="grid-item"> <img src="/upload/low/#= data[2].file_id + '.' + data[2].extension#"></div>
        # }#
        # if(data.length > 3) { #
        <div class="grid-item"> <img src="/upload/low/#= data[3].file_id + '.' + data[3].extension#"></div>
        #}#
    </script>
    <script type="text/javascript">
        $(function () {
            WishListPage.initPage()
        })
    </script>
@endsection