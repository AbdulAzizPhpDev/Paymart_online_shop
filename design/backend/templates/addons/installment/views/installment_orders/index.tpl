{script src="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.4/pagination.min.js"}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.4/pagination.css" />

{script src="js/addons/installment/backend/admin/contracts/func.js"}
{*{fn_print_die($paymart_orders->data)}*}
<div class="admin-contracts-list">
    <header class="header">
        <h1>Заказы</h1>
    </header>
    {include file="addons/installment/views/installment_orders/components/statuses-tab.tpl"}
    {if !empty($paymart_orders->data)}
        {foreach from=$paymart_orders->data item=order}
            {include file="addons/installment/views/installment_orders/components/contract-item.tpl" order=$order is_admin=true}
        {/foreach}
        <div class="pagination-contracts" data-contracts-count="{$paymart_orders->response->total}"></div>
        {* Show Tracking Modal  *}
        <div class="modal signin-modal tracking-contract-modal" style="display: none;">
            <div class="modal-header">
                <div><h3>{__('track_request_subj')}</h3></div>
                <button class="close-tracking-contract-modal">&times;</button>
            </div>
            <div class="modal-body tracking-modal-body" style="overflow-y: auto;"></div>
        </div>
    {else}
        <h4>{__('empty')}</h4>
    {/if}
</div>