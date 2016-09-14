@extends('layouts.main')

@section('content')
    <!-- Main Content -->
    <!--suppress ALL -->
    <section class="content-wrap">
        <div class="page-title">
            <div class="row">
                <div class="col s6 m6 l6">
                    <h1>Goby Team</h1>
                </div>
                <div class="col s6 m6 l6" >
                    <div class="right">

                    </div>
                </div>
            </div>
        </div>
        <form id="team-form"  data-parsley-excluded=".close, input[type=text]:hidden" >
            <div class="card-panel m-t-50">
                <div class="col l6">
                    <div class="avatar-img">
                        <div class="fm-account-blocks avatar-bl">
                            {{--<img src="{{ (isset($edit)) ? '/assets/upload'.'/low/'.$team->avatar->file_id.'.'.$team->avatar->extension : ''}}" style="display: block">--}}
                            <div id="image-cropper">
                                <div class="fm-account-avatar">
                                    <img class="img-avatar" src="{{ (isset($edit)) ? '/upload'.'/full/'.$team->avatar->file_id.'.'.$team->avatar->extension : ''}}" style="{{ isset($edit) ?  'display: block;' : '' }}">
                                    <div data-color="color9" class="avatar-wrapper avatar color9">
                                            <span>
                                                N
                                            </span>
                                        <div class="cropit-preview" style="width: 156px;height: 156px;"></div>

                                    </div>
                                    <div class="avatar-change-image">
                                        <span class="gb_sb">Thay đổi</span>
                                    </div>
                                </div>

                            {{--<input type="range" class="cropit-image-zoom-input" style="display:  none" />--}}

                            <!-- The actual file input will be hidden -->
                                <input type="file" class="cropit-image-input"  style="display: none;" {{ (!isset($edit)) ? 'required' : '' }}/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col l6">
                    <div class="row">
                        <div class="col m6 l6">
                            <label for="name">{{ trans('client_input.team_name') }}</label>
                            <input id="input-name" type="text" name="name" required value="{{ (isset($edit)) ? $team->name : '' }}">

                        </div>
                        <div class="col m6 l6">
                            <label for="career">{{ trans('client_input.career') }}</label>
                            <input id="input-name" type="text" name="career" value="{{ (isset($edit)) ? $team->career : '' }}" required>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </section>
    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a class="btn-floating btn-large red tooltipped " id="add-button" data-position="left" data-delay="50" data-tooltip="{{ !isset($edit) ? trans('client_title.tooltip_add_team') : trans('client_title.tooltip_edit_team') }}">
            <i class="mdi {{  (isset($edit)) ? 'mdi-editor-mode-edit' : 'mdi-content-add' }}"></i>
        </a>
    </div>
    @include('team.modal-detail')
@endsection

@section('scripts')
    <!--suppress JSUnresolvedFunction -->
    <script type="text/javascript">
        $(function(){
            "use strict";
            $(function(){
                window.conApp.hideSpin();
                $('.fm-account-avatar').on('click', function(e) {
                    $('.cropit-image-input').click();
                });
                $('#image-cropper').cropit({
                    onImageLoaded : function(){
                        $('.cropit-image-zoom-input').show();
                        $('.fm-account-avatar').off('click');
                        $('.avatar-change-image').toggleClass('show');
                        $('.img-avatar').hide();
                        $('#image-cropper .parsley-errors-list').hide();
                        $('.avatar-change-image').on('click', function(e) {
                            $('.cropit-image-input').click();
                        });
                    }
                });
                var formInstance = $("#team-form").parsley()
                $('#add-button').on('click', function(e){
                      if(formInstance.validate()) {
                          $('#modal-confirm').openModal();
                      }
                });
                $('#confirm_button').on('click', function(e){
                    e.preventDefault();
                    window.conApp.showSpin();
                    $('#modal-confirm').closeModal();
                    var imageData = $('#image-cropper').cropit('export', {
                        type: 'image/jpeg',
                        quality: .9,
                        originalSize : true
                    });
                    var data =  {
                        name : $('#team-form input[name="name"]:visible').val(),
                        career : $('#team-form input[name="career"]:visible').val(),
                        file : imageData
                    }
                    var edit = '{{ isset($edit) }}';
                    var request = {
                        method : '{{ isset($edit) ?  'PUT' : 'POST' }}',
                        data : data,
                        url : '{{ URL::route('team') }}' + '{{ isset($edit) ?  '/'.$team->team_id : '' }}',
                        success : function(response){
                            var $toastContent = $('<span>{{ trans('client_title.team_change_success') }}</span>');
                            Materialize.toast($toastContent, 5000);
                            window.conApp.hideSpin();
                           if(!edit){
                               window.location.href = '{{URL::route('team')}}';
                           }
                        },
                        error : function(error){
                            var error = error.responseJSON;
                            var $toastContent = $('<span>' + error.message +'</span>');
                            Materialize.toast($toastContent, 5000);
                            window.conApp.hideSpin();
                        }
                    }
                    window.conApp.ajaxCall(request);
                });

            });
        }(jQuery));
    </script>

@endsection