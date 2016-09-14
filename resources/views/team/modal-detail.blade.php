<div id="modal-confirm" class="modal w-30-p">
    <div class="modal-content">
        <h4>{{ trans('client_title.confirm_title') }}</h4>
        <p>{{ !isset($edit) ? trans('client_title.confirm_detail_add') :  trans('client_title.confirm_detail_edit') }}</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action waves-effect waves-red btn-flat" id="confirm_button">{{ trans('client_button.yes') }}</a>
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat "  id="confirm_reject">{{ trans('client_button.no') }}</a>
    </div>
</div>