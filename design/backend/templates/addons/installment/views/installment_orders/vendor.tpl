{script src="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.4/pagination.min.js"}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.4/pagination.css" />

{script src="js/addons/installment/backend/admin/contracts/func.js"}

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
                <button class="btn close-cancel-contract-modal">Нет</button>
                <button class="btn confirm-cancel-contract">Да</button>
            </div>
        </div>
        {* Modal - Accept Contract  *}
        <div class="modal signin-modal accept-contract-modal" style="display: none">
            <div class="modal-header">
                <h3>Принять договор</h3>
            </div>
            <div class="modal-footer">
                <button class="btn close-accept-contract-modal">Нет</button>
                <button class="btn confirm-accept-contract">Да</button>
            </div>
        </div>
    {else}
        <h4>Пусто</h4>
    {/if}
</div>