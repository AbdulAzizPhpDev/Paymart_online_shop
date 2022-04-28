<div class="order">
    <div class="head">
        <div class="info">
            <div class="contract-info">
                <h3>Договор клиента № {$order->contract->id}</h3>
                <p>от {$order->contract->created_at}</p>
            </div>
            <div class="buyer-info">
                {if $order->buyer->name != null}
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
                    {if $is_admin}
                        <td>{$product->price}</td>
                        <td>{($product->price * $product->amount) - ((($product->price * $product->amount) / 100) * 15 )}</td>
                        <td>15%</td>
                        <td>{((($product->price * $product->amount) / 100) * 15 )}</td>
                        <td>{$product->price * $product->amount}</td>
                    {else}
                        <td>{$product->price_discount}</td>
                        <td>{($product->price_discount * $product->amount) - ((($product->price_discount * $product->amount) / 100) * 15 )}</td>
                        <td>15%</td>
                        <td>{((($product->price_discount * $product->amount) / 100) * 15 )}</td>
                        <td>{$product->price_discount * $product->amount}</td>
                    {/if}
                </tr>
            {/foreach}
            <tr class="total-price">
                <td colspan="7">Итого</td>
                {if $is_admin}
                    <td>{$order->contract->total|number_format:false:false:' '}</td>
                {else}
                    <td>{$order->partner_total|number_format:false:false:' '}</td>
                {/if}
            </tr>
            </tbody>
{*            <tfoot>*}
{*            <tr></tr>*}
{*            </tfoot>*}
        </table>
    </div>
</div>