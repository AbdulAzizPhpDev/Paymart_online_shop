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
            {include file="addons/installment/views/installment_orders/components/contract-item.tpl" order=$order is_admin=true}
        {/foreach}
        <div class="pagination-contracts" data-contracts-count="{$paymart_orders->response->total}"></div>
        {* Show Tracking Modal  *}
        <div class="modal signin-modal tracking-contract-modal" style="display: none;">
            <div class="modal-header">
                <div><h3>Tracking Products</h3></div>
                <button class="close-tracking-contract-modal">&times;</button>
            </div>
            <div class="modal-body tracking-modal-body">
                {include file="addons/installment/views/installment_orders/components/stepper.tpl"}
            </div>
            {*<div class="modal-footer">
                <button class="btn close-tracking-contract-modal">Нет</button>
                <button class="btn confirm-tracking-contract">Да</button>
            </div>*}
        </div>
    {else}
        <h4>Пусто</h4>
    {/if}
</div>