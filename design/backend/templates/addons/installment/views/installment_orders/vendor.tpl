{script src="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.4/pagination.min.js"}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.4/pagination.css" />

{script src="js/addons/installment/backend/admin/contracts/func.js"}
{*{fn_print_die($paymart_orders)}*}

<div class="admin-contracts-list">
    <header class="header">
        <h1>Заказы</h1>
    </header>
    {include file="addons/installment/views/installment_orders/components/statuses-tab.tpl"}
    {if $paymart_orders->data|count > 0}
        {foreach from=$paymart_orders->data item=order}
            {include file="addons/installment/views/installment_orders/components/contract-item.tpl" order=$order is_admin=false}
        {/foreach}
        <div class="pagination-contracts" data-contracts-count="{$paymart_orders->response->total}"></div>
        {*<div class="pagination-wrap clearfix">
            <div class="pagination pagination-start">
                <ul>
                    <li class="disabled cm-history mobile-hide">
                        <a data-ca-scroll=".cm-pagination-container" class=" cm-history pagination-item">
                            <span class="cs-icon icon icon-double-angle-left"></span>
                        </a>
                    </li>
                    <li class="disabled cm-history">
                        <a data-ca-scroll=".cm-pagination-container" class=" cm-history pagination-item">
                            <span class="cs-icon icon icon-angle-left"></span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="pagination-dropdown">
                <div class="btn-group ">
                    <a class="pagination-selector btn dropdown-toggle" data-toggle="dropdown">
                        <span>1</span>–<span>10</span>&nbsp;из&nbsp;260
                        <span class="caret"></span>
                    </a>
                    <ul id="tools_list_pagination_2066870258" class="dropdown-menu cm-smart-position">
                        <li>
                            <a data-ca-scroll=".cm-pagination-container"
                               class="cm-ajax cm-history pagination-dropdown-per-page"
                               href="http://market.paymart.uz/admin.php?dispatch=products.manage&amp;items_per_page=10"
                               data-ca-target-id="pagination_contents">
                                10 на страницу
                            </a>
                        </li>
                        <li>
                            <a data-ca-scroll=".cm-pagination-container"
                               class="cm-ajax cm-history pagination-dropdown-per-page"
                               href="http://market.paymart.uz/admin.php?dispatch=products.manage&amp;items_per_page=25"
                               data-ca-target-id="pagination_contents">
                                25 на страницу
                            </a>
                        </li>
                        <li>
                            <a data-ca-scroll=".cm-pagination-container"
                               class="cm-ajax cm-history pagination-dropdown-per-page"
                               href="http://market.paymart.uz/admin.php?dispatch=products.manage&amp;items_per_page=50"
                               data-ca-target-id="pagination_contents">
                                50 на страницу
                            </a>
                        </li>
                        <li>
                            <a data-ca-scroll=".cm-pagination-container"
                               class="cm-ajax cm-history pagination-dropdown-per-page"
                               href="http://market.paymart.uz/admin.php?dispatch=products.manage&amp;items_per_page=100"
                               data-ca-target-id="pagination_contents">
                                100 на страницу
                            </a>
                        </li>
                        <li>
                            <a data-ca-scroll=".cm-pagination-container"
                               class="cm-ajax cm-history pagination-dropdown-per-page"
                               href="http://market.paymart.uz/admin.php?dispatch=products.manage&amp;items_per_page=250"
                               data-ca-target-id="pagination_contents">
                                250 на страницу
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pagination pagination-end">
                <ul>
                    <li class=" cm-history pagination-item">
                        <a data-ca-scroll=".cm-pagination-container" class="cm-ajax cm-history pagination-item"
                           href="http://market.paymart.uz/admin.php?dispatch=products.manage&amp;page=2"
                           data-ca-page="2"
                           data-ca-target-id="pagination_contents">
                            <span class="cs-icon icon icon-angle-right"></span>
                        </a>
                    </li>

                    <li class=" cm-history mobile-hide">
                        <a data-ca-scroll=".cm-pagination-container" class="cm-ajax cm-history pagination-item"
                           href="http://market.paymart.uz/admin.php?dispatch=products.manage&amp;page=26"
                           data-ca-page="26"
                           data-ca-target-id="pagination_contents">
                            <span class="cs-icon icon icon-double-angle-right"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>*}
        {* Modal - Cancel Contract  *}
        <div class="modal signin-modal cancel-contract-modal" style="display: none">
            <div class="modal-header">
                <h3>Отменить договор</h3>
            </div>
            {*<div class="modal-body">
                <label for="cancel-contract-code">Введите SMS код</label>
                <input type="text" id="cancel-contract-code" style="width: 100%; color: #000" maxlength="4">
                <p class="cancel-contract-error" style="color: red"></p>
            </div>*}
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
            {*<div class="modal-body">
                <label for="cancel-contract-code">Введите SMS код</label>
                <input type="text" id="cancel-contract-code" style="width: 100%; color: #000" maxlength="4">
                <p class="cancel-contract-error" style="color: red"></p>
            </div>*}
            <div class="modal-footer">
                <button class="btn close-accept-contract-modal">Нет</button>
                <button class="btn confirm-accept-contract">Да</button>
            </div>
        </div>
    {else}
        <h4>Пусто</h4>
    {/if}
</div>