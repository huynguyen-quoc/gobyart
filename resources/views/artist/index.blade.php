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
                </div>
            </div>
            <div class="table-content m-t-50 z-depth-2">
                <div class="card ">
                    <div class="content">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 80%">Tên</th>
                                        <th style="width: 20%">Thể Loại</th>
                                        {{--<th>Action</th>--}}
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach($artists as $artist)
                                    <tr data-id="{{ $artist->artist_id }}">
                                        <td>
                                            <img src="{{ ($artist->avatar) ? '/upload'.'/low/'.$artist->avatar->file_id.'.'.$artist->avatar->extension : ''}}" alt="{{ ucwords($artist->full_name) }}" class="circle photo"> {{ ucwords($artist->full_name) }}
                                        </td>

                                        <td>{{ ucwords($artist->music_category->type->name) }}</td>
                                        {{--<td><a href="#!" class="btn btn-small z-depth-0 team-delete"><i class="mdi mdi-action-delete"></i></a></td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="select-row">
    </section>
    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a class="btn-floating btn-large red tooltipped" href="{{URL::route('artist.new')}}" data-position="left" data-delay="50" data-tooltip="{{ trans('client_title.tooltip_add_artist') }}">
            <i class="mdi mdi-content-add"></i>
        </a>
    </div>


@endsection

@section('scripts')
    <script id="tableTemplate" type="text/x-kendo-template">
        # for (var i = 0; i < data.length; i++) { #
            <tr>
                <td>
                    <img src="#= data[i].avatar.file_id#.#= data[i].avatar.file_extension#" alt="#=data[i].name#" class="circle photo">
                    #=data[i].name#
                </td>
                <td>#=data[i].career#</td>
            </tr>
        # } #
    </script>
    <!--suppress JSUnresolvedFunction -->
    <script type="text/javascript">
    $(function(){
            "use strict";

            $(function(){
                window.conApp.hideSpin();
                $('table').on('click', 'tbody tr', function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    var id = $(this).data('id');
                    window.location.href = '{{ URL::route('artist') }}' + '/edit/' + id;
                });

                $('table').on('click', '.team-delete', function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    var id = $(this).closest('tr').data('id');
                    $('#select-row').val(id)
                    $('#modal-confirm').openModal();
                });

                $('#confirm_button').on('click', function(e){
                    e.preventDefault();
                    window.conApp.showSpin();
                    $('#modal-confirm').closeModal();
                    var id = $('#select-row').val();
                    var request = {
                        method : 'DELETE',
                        url : '{{ URL::route('artist') }}' + '/' + id,
                        success : function(response){
                            var $toastContent = $('<span>{{ trans('client_title.team_delete_success') }}</span>');
                            Materialize.toast($toastContent, 5000);
                            $('table tr[data-id="' + id + '"]').remove();
                            window.conApp.hideSpin();
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