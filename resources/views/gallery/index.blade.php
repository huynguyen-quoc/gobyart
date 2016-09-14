@extends('layouts.main')

@section('content')
    <!-- Main Content -->
    <!--suppress ALL -->
    <section class="content-wrap">
        <!-- Breadcrumb -->
        <div class="page-title">

            <div class="row">
                <div class="col s7 m6 l6">
                    <h1>Sự Kiện</h1>
                </div>
                <div class="col s5 m6 l6" id="paging-data">
                    <ul class="pagination right">
                        <li id="prevPage" class="{{ $files->currentPage() == 1 ? 'disabled' : 'waves-effect' }}">
                            <a href="#!"  data-value="prev" data-total="{{$files->lastPage()}}" ><i class="mdi-navigation-chevron-left"></i>
                            </a>
                        </li>
                        @foreach($paging_numbers as $item)
                            <li class="{{$files->currentPage() == $item ? 'active' : 'waves-effect'}} hide-on-small-only">
                                <a  href="#!" data-value="{{ $item }}"  data-total="{{$files->lastPage()}}"   href="#!">{{$item}}</a>
                            </li>
                        @endforeach
                        <li id="nextPage"  class="{{ $files->currentPage() ==  $files->lastPage() ? 'disabled' : 'waves-effect' }}">
                            <a href="#!" data-value="next"  data-total="{{$files->lastPage()}}"><i class="mdi-navigation-chevron-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
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
                                                        <img data-id="{{ $file->file_id }}" data-date="{{ $file->created_at }}" data-name="{{ $file->original_name.'.'.$file->extension}}"  data-size="{{ $file->width.'x'.$file->height}}" src="{{ '/upload'.'/low/'.$file->file_id.'.'.$file->extension}}" alt="" class="z-depth-2 z-depth-3-hover image-detail-toggle" />
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

        </div>

    </section>

    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a class="btn-floating btn-large red modal-trigger tooltipped"  data-position="left" data-delay="50" data-tooltip="{{ trans('client_title.tooltip_upload_gallery') }}" href="#modal-upload-gallery">
            <i class="mdi mdi-file-cloud-upload"></i>
        </a>
    </div>

    @include('gallery.modal')

    @include('gallery.modal-upload')

    @include('gallery.image-detail')

@endsection

@section('scripts')
    <script id="fileTemplate" type="text/x-kendo-template">
        <div class="grid-column-sizer"></div>
        # for (var i = 0; i < data.length; i++) { #
            <div class="grid-item p-5-p">
                <article class="gallery gallery-item">
                    <div class="gallery-img-wrapper">
                        <a href="">
                            <img data-id="#=data[i].file_id#" data-date="#=data[i].created_at#" data-name="#=data[i].original_name#.#=data[i].extension#"
                                 data-size="#=data[i].width#x#=data[i].height#" src="/upload/low/#=data[i].file_id#.#=data[i].extension#" alt="" class="z-depth-2 z-depth-3-hover image-detail-toggle" />
                        </a>
                    </div>
                </article>
            </div>
        # } #
    </script>

    <script id="fileUploadTemplate" type="text/x-kendo-template">
        <div class="grid-item p-5-p">
            <article class="gallery gallery-item">
                <div class="gallery-img-wrapper">
                    <a href="">
                        <img data-id="#=data.file_id#" data-date="#=data.created_at#" data-name="#=data.original_name#.#=data.extension#"
                             data-size="#=data.width#x#=data.height#" src="/upload/low/#=data.file_id#.#=data.extension#" alt="" class="z-depth-2 z-depth-3-hover image-detail-toggle" />
                    </a>
                </div>
            </article>
        </div>
    </script>

    <script id="pagingTemplate" type="text/x-kendo-template">
        <ul class="pagination right">
            <li id="prevPage"  class="#=data.files.current_page == 1 ? 'disabled' : 'waves-effect'#">
                <a href="\\#!" data-value="prev" data-total="#=data.files.last_page#"><i class="mdi-navigation-chevron-left"></i>
                </a>
            </li>
            # for (var i = 0; i < data.numbers.length; i++) { #
                <li  class="#=data.files.current_page == data.numbers[i] ? 'active' : 'waves-effect'# hide-on-small-only">
                    <a  href="\\#!" data-value="#=data.numbers[i]#"  data-total="#=data.files.last_page#" >#=data.numbers[i]#</a>
                </li>
            # } #
            <li id="nextPage"  class="#= (data.files.current_page == data.files.last_page) ? 'disabled' : 'waves-effect'#">
                <a href="\\#!" data-value="next"  data-total="#=data.files.last_page#" ><i class="mdi-navigation-chevron-right"></i></a>
            </li>
        </ul>
    </script>

    <!--suppress JSUnresolvedFunction -->
    <script type="text/javascript">
    $(function(){
            "use strict";

            var $grid;

            Dropzone.options.galleryDropzone = {
                url: '{{ URL::route('gallery') }}',
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

                    $grid.append($file[0]).isotope('appended', $file[0]).isotope('layout');
                    $(window).trigger('resize');
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

                $('#paging-data').on('click', 'a', function(e){
                    e.preventDefault();
                    var number = $(this).data('value');
                    var total = $(this).data('total');
                    if(number == 'prev'){
                        number = $('.pagination li.active a').data('value');
                        number = parseInt(number)  - 1;
                    }else if(number == 'next'){
                        number = $('.pagination li.active a').data('value');
                        number = parseInt(number)  + 1;
                    }

                    if(number < 1 || number > total) return;
                    window.conApp.showSpin();
                    var request = {
                        method : 'GET',
                        url : '{{ URL::route('gallery') }}?' + "page=" + number,
                        success : function(response){
                            var files = response.files;
                            var numbersP = response.paging_numbers;
                            var scriptTemplate = kendo.template($("#fileTemplate").html());
                            var imagesList =  scriptTemplate(files.data);

                            var pagingTemp = kendo.template($("#pagingTemplate").html());
                            var pagingNumbers =  pagingTemp({ files : files, numbers : numbersP});
                            $('#galleryFiles').html(imagesList);
                            $('#paging-data').html(pagingNumbers);
                            $grid.isotope('destroy').isotope({
                                itemSelector: '.grid-item',
                                percentPosition: true,
                                masonry: {
                                    // use outer width of grid-sizer for columnWidth
                                    columnWidth: '.grid-column-sizer'
                                }
                            });
                            window.conApp.hideSpin();
                        },
                        error : function(error){
                            var error = error.responseJSON;
                            window.conApp.hideSpin();
                        }
                    };
                    window.conApp.ajaxCall(request);
                })
            });
        }(jQuery));
    </script>

@endsection