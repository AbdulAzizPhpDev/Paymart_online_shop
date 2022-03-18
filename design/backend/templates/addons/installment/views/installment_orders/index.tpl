{script src="js/addons/installment/backend/admin/contracts/func.js"}
{*        {fn_print_die($paymart_orders->data)}*}

<div class="admin-contracts-list">
    <header class="header">
        <h1>Заказы</h1>
    </header>

    <div class="order-status-tabs">
        <span>Все договоры (1691)</span>
        <span>На модерации</span>
        <span>В рассрочке</span>
        <span>Загрузить акт (1494)</span>
        <span>Просрочен</span>
    </div>

    {foreach from=$paymart_orders->data item=order}
        <div class="order">
            <div class="head">
                <div class="info">
                    <div class="contract-info">
                        <h3>Договор № {$order->contract->id}</h3>
                        <p>от {$order->contract->created_at}</p>
                    </div>
                    <div class="buyer-info">
                        {if $order->buyer|count > 0}
                            <h3>{$order->buyer->surname} {$order->buyer->name} {$order->buyer->patronymic}</h3>
                        {else}
                            <h3>Robert Fox (Test name)</h3>
                        {/if}
                        <p>Тел: {$order->buyer->phone}</p>
                    </div>
                </div>
                <div class="status status-{$order->contract->status}">
                    {$order->contract->status_caption}
                </div>
            </div>
            <div class="products-table">
                <table class="table table-middle table--relative table-responsive">
                    <thead>
                    <tr>
                        <th scope="col">Наименование</th>
                        <th scope="col">Ед.изм</th>
                        <th scope="col">Кол-во</th>
                        <th scope="col">Цена</th>
                        <th scope="col">Сумма</th>
                        <th scope="col">НДС%</th>
                        <th scope="col">Сумма НДС</th>
                        <th scope="col">Всего с НДС</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$order->products item=product}
                        <tr>
                            <td>{$product->name}</td>
                            <td>Шт</td>
                            <td>{$product->amount}</td>
                            <td>{$product->price}</td>
                            <td>{($product->price * $product->amount) - ((($product->price * $product->amount) / 100) * 15 )}</td>
                            <td>15%</td>
                            <td>{((($product->price * $product->amount) / 100) * 15 )}</td>
                            <td>{$product->price * $product->amount}</td>
                        </tr>
                    {/foreach}
                    <tr class="total-price">
                        <td colspan="3">Итого</td>
                        <td></td>
                        <td></td>
                        <td>15%</td>
                        <td></td>
                        <td>{$order->contract->total}</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>
                            <button class="btn">Распечатать АКТ</button>
                        </td>
                        <td colspan="6"></td>
                        <td>
                            <button class="btn">Отменить договор</button>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    {/foreach}

    <div class="pagination-wrap clearfix">
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
                        <a data-ca-scroll=".cm-pagination-container" class="cm-ajax cm-history pagination-dropdown-per-page" href="http://market.paymart.uz/admin.php?dispatch=products.manage&amp;items_per_page=10" data-ca-target-id="pagination_contents">
                            10 на страницу
                        </a>
                    </li>
                    <li>
                        <a data-ca-scroll=".cm-pagination-container" class="cm-ajax cm-history pagination-dropdown-per-page" href="http://market.paymart.uz/admin.php?dispatch=products.manage&amp;items_per_page=25" data-ca-target-id="pagination_contents">
                            25 на страницу
                        </a>
                    </li>
                    <li>
                        <a data-ca-scroll=".cm-pagination-container" class="cm-ajax cm-history pagination-dropdown-per-page" href="http://market.paymart.uz/admin.php?dispatch=products.manage&amp;items_per_page=50" data-ca-target-id="pagination_contents">
                            50 на страницу
                        </a>
                    </li>
                    <li>
                        <a data-ca-scroll=".cm-pagination-container" class="cm-ajax cm-history pagination-dropdown-per-page" href="http://market.paymart.uz/admin.php?dispatch=products.manage&amp;items_per_page=100" data-ca-target-id="pagination_contents">
                            100 на страницу
                        </a>
                    </li>
                    <li>
                        <a data-ca-scroll=".cm-pagination-container" class="cm-ajax cm-history pagination-dropdown-per-page" href="http://market.paymart.uz/admin.php?dispatch=products.manage&amp;items_per_page=250" data-ca-target-id="pagination_contents">
                            250 на страницу
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pagination pagination-end">
            <ul>
                <li class=" cm-history pagination-item">
                    <a data-ca-scroll=".cm-pagination-container" class="cm-ajax cm-history pagination-item" href="http://market.paymart.uz/admin.php?dispatch=products.manage&amp;page=2" data-ca-page="2" data-ca-target-id="pagination_contents">
                        <span class="cs-icon icon icon-angle-right"></span>
                    </a>
                </li>

                <li class=" cm-history mobile-hide">
                    <a data-ca-scroll=".cm-pagination-container" class="cm-ajax cm-history pagination-item" href="http://market.paymart.uz/admin.php?dispatch=products.manage&amp;page=26" data-ca-page="26" data-ca-target-id="pagination_contents">
                        <span class="cs-icon icon icon-double-angle-right"></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>