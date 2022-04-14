{script src="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.4/pagination.min.js"}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.4/pagination.css" />

{script src="js/addons/installment/backend/admin/contracts/func.js"}
{*{fn_print_die($paymart_orders)}*}
<div class="admin-contracts-list">
    <header class="header">
        <h1>Заказы</h1>
    </header>
    {include file="addons/installment/views/installment_orders/components/statuses-tab.tpl"}
    {if !empty($paymart_orders->data)}
        {foreach from=$paymart_orders->data item=order}
            {include file="addons/installment/views/installment_orders/components/contract-item.tpl" order=$order is_admin=false}
        {/foreach}
        <div class="pagination-contracts" data-contracts-count="{$paymart_orders->response->total}"></div>
        {* Modal - Upload Act *}
        <div class="modal signin-modal upload-act-modal" style="display: none">
            <div class="modal-header">
                <h3>Загрузить акт</h3>
            </div>
            <div class="modal-body" style="display: flex; flex-direction: column; align-items: center">
                <div class="imei-preview"></div>
                <input id="imei-uploader" type="file" hidden accept=".jpeg, .jpg, png">
                <label for="imei-uploader" style="display: flex; align-items: center;">
                    <svg style="margin-right: 8px;" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 9.016V14.984M9.016 12H14.984M18.332 21.332H5.66797C4.01097 21.332 2.66797 19.989 2.66797 18.332V5.66797C2.66797 4.01097 4.01097 2.66797 5.66797 2.66797H18.332C19.989 2.66797 21.332 4.01097 21.332 5.66797V18.332C21.332 19.989 19.989 21.332 18.332 21.332Z"
                              stroke="#FF7643" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    {__('insert_image')}
                </label>
            </div>
            <div class="modal-footer">
                <button class="btn close-upload-act-modal">{__('false')}</button>
                <button class="btn confirm-upload-act">{__('upload_file')}</button>
            </div>
        </div>
        {* Modal - Cancel Contract  *}
        <div class="modal signin-modal cancel-contract-modal" style="display: none">
            <div class="modal-header">
                <h3>Отменить договор</h3>
            </div>
            <div class="modal-footer">
                <button class="btn close-cancel-contract-modal">{__('false')}</button>
                <button class="btn confirm-cancel-contract">{__('yes')}</button>
            </div>
        </div>
        {* Modal - Accept Contract  *}
        <div class="modal signin-modal accept-contract-modal" style="display: none">
            <div class="modal-header">
                <h3>Принять договор</h3>
            </div>
            <div class="modal-footer">
                <button class="btn close-accept-contract-modal">{__('false')}</button>
                <button class="btn confirm-accept-contract">{__('yes')}</button>
            </div>
        </div>
        {* Show Bar Code Modal  *}
        <div class="modal signin-modal bar-code-modal" style="display: none;">
            <div class="modal-header">
                <div><h3>{__('yml2_offer_feature_common_barcode')}</h3></div>
                <button class="close-bar-code-modal">&times;</button>
            </div>
            <div class="modal-body bar-code-modal-body">
                {__('empty')}
            </div>
        </div>
        {* Show Tracking Modal  *}
        <div class="modal signin-modal tracking-contract-modal" style="display: none;">
            <div class="modal-header">
                <div><h3>{__('track_request_subj')}</h3></div>
                <button class="close-tracking-contract-modal">&times;</button>
            </div>
            <div class="modal-body tracking-modal-body">
                {include file="addons/installment/views/installment_orders/components/stepper.tpl"}
            </div>
        </div>
    {else}
        <h4>Пусто</h4>
    {/if}
</div>