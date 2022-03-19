{script src="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.4/pagination.min.js"}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.4/pagination.css" />

{script src="js/addons/installment/backend/admin/contracts/func.js"}
{*{fn_print_die($paymart_orders->data)}*}
<div class="admin-contracts-list">
    <header class="header">
        <h1>Заказы</h1>
    </header>
    {include file="addons/installment/views/installment_orders/components/statuses-tab.tpl"}
    {if $paymart_orders->data|count > 0}
        {foreach from=$paymart_orders->data item=order}
            {include file="addons/installment/views/installment_orders/components/contract-item.tpl" order=$order is_admin=true}
        {/foreach}
        <div class="pagination-contracts" data-contracts-count="{$paymart_orders->response->total}"></div>
        {*<div class="modal signin-modal cancel-contract-modal" style="display: none">
            <div class="modal-header">
                <h3>Отменить договор</h3>
            </div>
            <div class="modal-body">
                <label for="cancel-contract-code">Введите SMS код</label>
                <input type="text" id="cancel-contract-code" style="width: 100%; color: #000" maxlength="4">
                <p class="cancel-contract-error" style="color: red"></p>
            </div>
            <div class="modal-footer">
                <button class="btn close-cancel-contract-modal">Нет</button>
                <button class="btn confirm-cancel-contract">Да</button>
            </div>
        </div>*}
    {else}
        <h4>Пусто</h4>
    {/if}
</div>