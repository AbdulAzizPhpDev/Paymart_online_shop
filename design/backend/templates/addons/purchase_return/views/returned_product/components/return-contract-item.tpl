<div class="order">
    <div class="head">
        <div class="info">
            <div class="contract-info">
                <h3>Договор клиента № {$order['contract_id']}</h3>
                <p>от {$order['timestamp']|date_format}</p>
            </div>
            <div class="contract-info">
                {if $order['user']['firstname'] != null}
                    <h3>{$order['user']['firstname']} {$order['user']['lastname']}</h3>
                {else}
                    <h3>Robert Fox (Test name)</h3>
                {/if}
                <p>Тел: {$order['user']['phone']}</p>
            </div>
            <div class="contract-info">
                <h3>{$order['company']['company']}</h3>
                <p>{$order['company']['state']} {$order['company']['address']}</p>
            </div>
        </div>
        <div class="status status-{$order['status']}">
            {$order['status']}
        </div>
    </div>
    <div class="products-table">
        <table class="table table-middle table--relative table-responsive">
            <thead>
            <tr>
                <th scope="col">Фото товара</th>
                <th scope="col">Наименование</th>
                <th scope="col">Кол-во</th>
                <th scope="col">Цена</th>
                <th scope="col">Сумма</th>
            </tr>
            </thead>
            <tbody>
            {foreach $order['product_data'] as $product_id => $product}
                <tr>
                    <td>
                        <img src="/var/custom_files/{$product['image']}" alt="" width="80">
                    </td>
                    <td>{$product['name']}</td>
                    <td>{$product['quantity']}</td>
                    <td>{$product['price']}</td>
                    <td>{$product['quantity'] * $product['price']}</td>
                </tr>
            {/foreach}
            <tr class="total-price">
                <td colspan="4">Итого</td>
                <td>75400</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5"></td>
            </tr>
            </tfoot>
        </table>

        {if !empty($order['description'])}
            <section class="comments">
                <h3 style="margin-bottom: 0;">Комментарии</h3>
                <dl style="margin: 0;">
                    {if !empty($order['description']['user'])}
                        <dt>Клиент</dt>
                        <dd>{$order['description']['user']['description']}</dd>
                    {/if}
                    {if !empty($order['description']['vendor'])}
                        <dt>Вендор</dt>
                        <dd>{$order['description']['vendor']['description']}</dd>
                    {/if}
                </dl>
            </section>
        {/if}

        <div style="text-align: right;">
            <button
                    class="btn return-accept-btn"
                    data-user-id="{$order['user']['user_id']}"
                    data-order-id="{$order['order_id']}"
                    data-company-id="{$order['company']['company_id']}"
            >
                {__('accept')}
            </button>
            <button
                    class="btn return-cancel-btn"
                    data-user-id="{$order['user']['user_id']}"
                    data-order-id="{$order['order_id']}"
                    data-company-id="{$order['company']['company_id']}"
            >
                {__('decline')}
            </button>
        </div>
    </div>
</div>