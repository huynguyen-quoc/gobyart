@extends('layouts.main')

@section('content')
    <!-- Main Content -->
    <!--suppress ALL -->
    <section class="content-wrap">
        <div class="page-title">
            <div class="row">
                <div class="col s6 m6 l6">
                    <h1>{{ (!isset($edit)) ? 'Thêm Nghệ Sĩ' :  ucwords($artist->full_name) }}</h1>
                </div>
                <div class="col s6 m6 l6" >
                    <div class="right">

                    </div>
                </div>
            </div>
        </div>
        <form id="artist-form"  data-parsley-excluded=".close, input[type=text]:hidden" >
            <div class="card-panel m-t-50">
                <div class="col l6">
                    <div class="avatar-img">
                    <div class="fm-account-blocks avatar-bl">
                        {{--<img src="{{ (isset($edit)) ? '/assets/upload'.'/low/'.$team->avatar->file_id.'.'.$team->avatar->extension : ''}}" style="display: block">--}}
                        <div id="image-cropper">
                            <div class="fm-account-avatar">
                                <img class="img-avatar" src="{{ (isset($edit)) ? '/upload'.'/full/'.$artist->avatar->file_id.'.'.$artist->avatar->extension : ''}}" style="{{ isset($edit) ?  'display: block;' : '' }}">
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
                    <div class="input-field">
                        <div class="row">
                            <div class="col m6 l6">
                                <input id="input-name" type="text" name="first_name" value="{{ (isset($edit)) ? $artist->first_name : '' }}" required>
                                <label for="full_name">{{ trans('client_input.first_name') }}</label>
                            </div>
                            <div class="col m6 l6">
                                <input id="input-name" type="text" name="last_name" value="{{ (isset($edit)) ? $artist->last_name : '' }}" required>
                                <label for="full_name">{{ trans('client_input.last_name') }}</label>
                            </div>
                        </div>

                    </div>
                    <!-- Status Message -->
                    <div class="input-field">
                        <div class="row">
                            <div class="col m6 l6">
                                <input id="input-name" type="text" name="full_name" value="{{ (isset($edit)) ? $artist->full_name : '' }}" required>
                                <label for="full_name">{{ trans('client_input.full_name') }}</label>
                            </div>
                            <div class="col m6 l6">
                                <input id="date_of_birth" name="date_of_birth" class="pikaday" type="text" value="{{ (isset($edit)) ? $artist->date_of_birth->format('d/m/Y') : '' }}">
                                <label for="full_name">{{ trans('client_input.date_of_birth') }}</label>
                            </div>
                        </div>

                    </div>
                    <!-- /Status Message -->
                    <!-- Artist Type -->
                    <div class="input-field">
                        <div class="row">
                            <div class="col m6 l6">
                                <select id="artist_select_1"  name="artist_type_id" class="artist_select" required>
                                    @foreach($artistTypes as $index=>$type)
                                        <option value="{{ $type->type_id }}" {{ (isset($edit)) ?  $type->type_id == $artist->music_category->type->type_id : $index == 0 ? 'selected' : ''  }}>{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col m6 l6 music_category_data">


                            </div>
                        </div>

                    </div>
                    <!-- Artist Type -->
                </div>
            </div>

            <div class="card-panel">
                <div class="input-field">
                    <div class="row">
                        <div class="col l12">
                            <textarea id="description" class="materialize-textarea " name="description" required> {{ (isset($edit)) ? $artist->description : '' }}</textarea>
                            <label for="description">{{ ucwords('Kinh Nghiệm') }}</label>
                        </div>
                    </div>

                </div>

            </div>

            <div class="card-panel">
                <div class="input-field">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <input id="input-meta" type="text" name="meta" value="{{ (isset($edit)) ? $artist->seo->meta : '' }}">
                            <label for="meta">{{ trans('client_input.meta') }}</label>
                        </div>
                    </div>
                </div>
                <div class="input-field">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <textarea id="keywords" class="materialize-textarea " name="keywords"> {{ (isset($edit)) ? $artist->seo->keywords : '' }}</textarea>
                            <label for="keywords">{{ ucwords('Từ khoá') }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-panel">
                @if (isset($artistOptions) && $artistOptions != null && count($artistOptions) > 0)
                    @foreach($artistOptions as $option)
                        <div class="input-field">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <input type="text" name="extra_information.{{ strtolower($option->name) }}" value="{{  (isset($edit)) ? $artist->extra_information[strtolower($option->name)] : '' }}">
                                    <label for="meta">{{ trans('client_input.'.strtolower($option->name)) }}</label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="card-panel">
                <div class="dropzone" id="galleryDropzone" style="height:100%"></div>
                <input type="hidden" id="gallery_images" name="file_images">
            </div>
            <div class="card-panel of-h m-t-50">
                <div class="rows">
                    <div class="galleries">
                        <div id="galleryFiles" class="grid-masonry">
                            <div class="grid-column-sizer"></div>
                            @if (isset($files) && $files != null && count($files) > 0)
                                @foreach($files as $file)
                                    <div class="grid-item p-5-p">
                                        <article class="gallery gallery-item">
                                            <div class="gallery-img-wrapper">
                                                <a href="#!">
                                                    <img data-id="{{ $file->file_id }}" data-date="{{ $file->created_at }}" data-name="{{ $file->original_name.'.'.$file->extension}}"  data-size="{{ $file->width.'x'.$file->height}}" src="{{ '/upload'.'/full/'.$file->file_id.'.'.$file->extension}}" alt="" class="z-depth-2 z-depth-3-hover image-detail-toggle" />
                                                </a>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            @endif
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
    <script id="optionCategoryTemp" type="text/x-kendo-template">
        <select name="music_category_id" class="music_category" required>
        # for (var i = 0; i < data.length; i++) { #
            # if(data[i].type.type_id == $('\\#artist_select_1').val() || data[i].type.type_id == $('\\#artist_select_2').val()) {#
                <option value="#=data[i].category_id#">#=data[i].name#</option>
            # } #
        # } #
        </select>
    </script>
    <script id="fileUploadTemplate" type="text/x-kendo-template">
        <div class="grid-item p-5-p">
            <article class="gallery gallery-item">
                <div class="gallery-img-wrapper">
                    <a href="">
                        <img data-id="#=data.file_id#" data-date="#=data.created_at#" data-name="#=data.original_name#.#=data.extension#"
                             data-size="#=data.width#x#=data.height#" src="/upload/full/#=data.file_id#.#=data.extension#" alt="" class="z-depth-2 z-depth-3-hover image-detail-toggle" />
                    </a>
                </div>
            </article>
        </div>
    </script>
    <!--suppress JSUnresolvedFunction -->
    <script type="text/javascript">
        $(function(){
            "use strict";
            var $grid;
            Dropzone.options.galleryDropzone = {
                url: '{{ URL::route('artist') }}' + '/upload',
                dictDefaultMessage: '{{ trans('client_title.upload_image_drop_message') }}',
                dictInvalidFileType : '{{ trans('client_title.upload_image_drop_invalid_file_type_message') }}',
                acceptedFiles: "image/jpeg,image/png,image/gif,image/jpg",
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                maxFilesize: 4,
                error: function(file, response) {
                    if($.type(response) === "string")
                        var message = response; //dropzone sends it's own error messages in string
                    else
                        var message = response.message;
                    file.previewElement.classList.add("dz-error");
                    var _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                    var _results = [];
                    for (var _i = 0, _len = _ref.length; _i < _len; _i++) {
                        var  node = _ref[_i];
                        _results.push(node.textContent = message);
                    }
                    return _results;
                },
                success: function(file,done) {
                    var response = $.parseJSON(file.xhr.response);
                    var scriptTemplate = kendo.template($("#fileUploadTemplate").html());
                    var file =  scriptTemplate(response.image);
                    var $file = $(file);
                    var listImage = $('#gallery_images').val();
                    listImage += (listImage) ? ',' + response.image.file_id : response.image.file_id;
                    $('#gallery_images').val(listImage);
                    $grid.append($file[0]).isotope('appended', $file[0]).isotope('layout');
                    //$(window).trigger('resize');
                }
            };
            $(function(){
                window.conApp.hideSpin();
                $grid = $('#galleryFiles').isotope({
                    itemSelector: '.grid-item',
                    percentPosition: true,
                    masonry: {
                        // use outer width of grid-sizer for columnWidth
                        columnWidth: '.grid-column-sizer'
                    }
                });
                var categories = [];
                @foreach($musicCategories as $category)
                      categories.push(JSON.parse('{!!  $category !!}'));
                @endforeach
                var scriptTemplate = kendo.template($("#optionCategoryTemp").html());
                var file =  scriptTemplate(categories);

                $('.music_category_data').html(file);
                $('.music_category').val('{{ (isset($edit)) ?  $artist->music_category->category_id :'' }}');
                $('.music_category').material_select();
                $(".music_category:visible").on('change', function(e){

                    $('select.music_category').closest('div.select-wrapper:hidden').find('select').find('option[value="' + $(this).find('select').val() + '"]').prop('selected', true);
                    $('select.music_category:hidden').material_select();
                });

                $("#artist_select_1").on('change', function(e){
                    $("#artist_select_2").val($(this).val());
                    $('.music_category_data').html('');
                    var file =  scriptTemplate(categories);
                    $('.music_category_data').html(file);
                    $('.music_category').material_select();
                });
                $("#artist_select_2").on('change', function(e){
                    $("#artist_select_1").val($(this).val());
                    $('.music_category_data').html('');
                    var file =  scriptTemplate(categories);
                    $('.music_category_data').html(file);
                    $('.music_category').material_select();
                });

                $('.fm-account-avatar').on('click', function(e) {
                    $('.cropit-image-input').click();
                });
                var picker = new Pikaday({
                    field: document.getElementById('date_of_birth'),
                    format : "MM/DD/YYYY"
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

                var formInstance = $("#artist-form").parsley()
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
                    var formData = $('#artist-form').serializeObject();
                    //formData['artist_type_id'] = formData['artist_type_id'];
                    formData['first_name'] =  $('#artist-form input[name="first_name"]:visible').val();
                    formData['last_name'] =  $('#artist-form input[name="last_name"]:visible').val();
                    formData['full_name'] =  $('#artist-form input[name="full_name"]:visible').val();
                    //formData['music_category_id'] = formData['music_category_id'];
                    formData['file_images'] =  $('#gallery_images').val();
                    formData['file'] = imageData
                    var extra_information = {}
                    $.each(formData, function(key, item){
                       if(key.startsWith("extra_information")){
                          var keyData =  key.substring(key.indexOf('.') + 1,key.length);
                           extra_information[keyData] = item;
                           delete formData[key];
                       }
                    });
                    formData['extra_information'] = JSON.stringify(extra_information);
                    var edit = '{{ isset($edit) }}';
                    var request = {
                        method : '{{ isset($edit) ?  'PUT' : 'POST' }}',
                        data : formData,
                        url : '{{ URL::route('artist') }}' + '{{ isset($edit) ?  '/'.$artist->artist_id : '' }}',
                        success : function(response){
                            var $toastContent = $('<span>{{ trans('client_title.artist_change_success') }}</span>');
                            Materialize.toast($toastContent, 5000);
                            window.conApp.hideSpin();
                           if(!edit){
                               window.location.href = '{{URL::route('artist')}}';
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

                $(document).on('click', '.image-detail-toggle', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    var $this = $(this);
                    var date = $this.data('date');
                    var name = $this.data('name');
                    var id = $this.data('id');
                    var size = $this.data('size');
                    var url = $this.attr('src');
                    $('.image-detail .image .photo').attr("src", url);
                    $('.image-detail .image .name').html(date);
                    $('.image-detail .image .size').html(size);
                    $('.image-detail .image #file-image-id').val(id);
                    $('.image-detail #image-name').html(name);
                    if(!$('.image-detail').hasClass('layer-opened')) {
                        $('.image-detail').MDLayer();
                    }
                });
                $(document).on('click', '.image-detail-toggle-close', function(e) {
                    $('.image-detail').MDLayer('hide');
                });
                // close chat on document click
                $(document).on('click', function(e) {
                    $('.image-detail').MDLayer('hide');
                });
                // close chat on ESC press
                $(document).on('keyup', function(e) {
                    if (e.keyCode == 27) {
                        $('.image-detail').MDLayer('hide');
                    }
                });

                $(document).on('click', '.image-detail, #confirm_reject', function(e){
                    e.preventDefault();
                    e.stopPropagation();
                });

                $(document).on('click', '#confirm_delete', function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    var fileId = $('#file-image-id').val();
                    $('#modal-confirm').closeModal();
                    var request = {
                        method : 'DELETE',
                        url : '{{ URL::route('gallery') }}' + '/' + fileId,
                        success : function(response){
                            $('.image-detail').MDLayer('hide');
                            var $toastContent = $('<span>{{ trans('client_title.delete_gallery_image_success') }}</span>');
                            Materialize.toast($toastContent, 5000);
                            var items = $('.gallery-img-wrapper img[data-id="' + fileId + '"]').closest('.grid-item');
                            $grid.isotope( 'remove', items )
                            // layout remaining item elements
                                    .isotope('layout');

                        },
                        error : function(error){
                            var error = error.responseJSON;
                            var $toastContent = $('<span>' + error +'</span>');
                            Materialize.toast($toastContent, 5000);
                        }
                    };
                    window.conApp.ajaxCall(request);
                });

            });
        }(jQuery));
    </script>

@endsection