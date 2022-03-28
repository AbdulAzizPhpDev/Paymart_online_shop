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
                <iframe src="" frameborder="0" height="650" width="100%"></iframe>
{*                <img src="https://img.icons8.com/ios/32/000000/truck.png" alt="bar-code">*}
            </div>
        </div>
    {else}
        <h4>Пусто</h4>
    {/if}
</div>