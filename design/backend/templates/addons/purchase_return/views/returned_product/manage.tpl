{script src="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.4/pagination.min.js"}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.4/pagination.css" />

{script src="js/addons/installment/backend/admin/contracts/return.js"}
{*{fn_print_die($returned_products['data'])}*}
<div class="admin-contracts-list">
    <header class="header">
        <h1>Возврат</h1>
    </header>
{*    {include file="addons/installment/views/installment_orders/components/statuses-tab.tpl"}*}
    {if !empty($returned_products['data'])}
        {foreach $returned_products['data'] as $order}
{*            {include file="addons/installment/views/installment_orders/components/return-contract-item.tpl" order=$order is_admin=false}*}
            {include file="addons/purchase_return/views/returned_product/components/return-contract-item.tpl" order=$order}
        {/foreach}
        <div class="pagination-contracts" data-contracts-count="{$returned_products['quantity']}"></div>
        {* Modal - Upload Act *}
        <div class="modal signin-modal return-cancel-modal" style="display: none">
            <div class="modal-header">
                <h3>Отклонить запрос</h3>
            </div>
            <div class="modal-body">
                <p>Описание</p>
                <textarea rows="5"></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn confirm-return-cancel">{__('save')}</button>
                <button class="btn close-return-cancel">{__('close')}</button>
            </div>
        </div>
        {* Modal - Accept Contract  *}
        <div class="modal signin-modal return-accept-modal" style="display: none">
            <div class="modal-header">
                <h3>Принять запрос</h3>
            </div>
            <div class="modal-footer">
                <button class="btn confirm-accept-return">{__('yes')}</button>
                <button class="btn close-accept-return">{__('false')}</button>
            </div>
        </div>
    {else}
        <h4>Пусто</h4>
    {/if}
</div>