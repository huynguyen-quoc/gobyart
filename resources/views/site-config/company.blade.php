@extends('layouts.main')

@section('content')
    <!-- Main Content -->
    <section class="content-wrap">
        <!-- Breadcrumb -->
        <div class="page-title">

            <div class="row">
                <div class="col s12 m9 l10">
                   <h1>Thông Tin Công Ty</h1>
                </div>
            </div>

        </div>
        <!-- /Breadcrumb -->
        <div class="card-panel m-t-50">
            <form id="form-company" data-parsley-trigger="keyup">
                <div class="row">
                    @foreach($options as $index => $option)
                            <div class="col l12 m12 s12">
                                <div class="input-field {{ $option->option_input == 'html' ? 'input-editor' : '' }}">
                                    @if($option->option_input == 'text')
                                        <input  type="text"  name="{{ $option->name }}"
                                            value="{{$option->value}}">
                                        <label for="{{ $option->name }}">{{ ucwords(trans('site_config.'.$option->name)) }}</label>
                                    @else
                                        <textarea id="{{$option->name}}_{{$index}}" class="materialize-textarea {{$option->option_input}}" name="{{ $option->name }}">{{$option->value}}</textarea>
                                        <label for="{{ $option->name }}">{{ ucwords(trans('site_config.'.$option->name)) }}</label>
                                    @endif
                                </div>
                            </div>
                    @endforeach
                </div>
            </form>
        </div>
    </section>
    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a class="btn-floating btn-large red modal-trigger tooltipped"  data-position="left" data-delay="50" data-tooltip="{{ trans('client_title.tool_tip_change_company_information') }}" href="#modal-confirm">
            <i class="mdi mdi-editor-mode-edit"></i>
        </a>
    </div>
    <div id="modal-confirm" class="modal w-30-p">
        <div class="modal-content">
            <h4>{{ trans('client_title.confirm_title') }}</h4>
            <p>{{ trans('client_title.confirm_detail_edit') }}</p>
        </div>
        <div class="modal-footer">
            <a class="modal-action waves-effect waves-red btn-flat" id="confirm_change">{{ trans('client_button.yes') }}</a>
            <a class="modal-action modal-close waves-effect waves-green btn-flat ">{{ trans('client_button.no') }}</a>
        </div>
    </div>
@endsection

@section('scripts')
    <!--suppress JSUnresolvedFunction -->
    <script type="text/javascript">
        @foreach($options as $index => $option)
            @if($option->option_input == 'html')
                var editor{{$index}} = new SquireUI({
                    replace: '#{{$option->name}}_{{$index}}',
                    height: 200,
                    buildPath: '/assets/admin/assets/_con/squire/'
                });
            @endif
        @endforeach

        $(function(){
            "use strict";

            $(function(){
                window.conApp.hideSpin();
                $('#confirm_change').on('click', function(e){
                    e.preventDefault();
                    var data = $('#form-company').serializeObject();
                    @foreach($options as $index => $option)
                            @if($option->option_input == 'html')
                                data['{{$option->name}}'] = editor{{$index}}.getHTML();
                            @endif
                    @endforeach
                    $('#modal-confirm').closeModal();
                    var request = {
                        method : 'PUT',
                        data : data,
                        url : '/api/site-config/site_description',
                        success : function(response){
                            console.log(response)
                            var $toastContent = $('<span>{{ trans('client_title.company_info_change_success') }}</span>');
                            Materialize.toast($toastContent, 5000);
                        },
                        error : function(error){
                            var error = error.responseJSON;
                            var $toastContent = $('<span>' + error.message +'</span>');
                            Materialize.toast($toastContent, 5000);
                        }
                    }
                    window.conApp.ajaxCall(request);

                });
            });
        }(jQuery));
    </script>
@endsection