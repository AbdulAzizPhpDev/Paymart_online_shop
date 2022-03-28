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
                    <td>{$product->price_discount}</td>
                    <td>{($product->price_discount * $product->amount) - ((($product->price_discount * $product->amount) / 100) * 15 )}</td>
                    <td>15%</td>
                    <td>{((($product->price_discount * $product->amount) / 100) * 15 )}</td>
                    <td>{$product->price_discount * $product->amount}</td>
                </tr>
            {/foreach}
            <tr class="total-price">
                <td colspan="3">Итого</td>
                <td></td>
                <td></td>
                <td>15%</td>
                <td></td>
                <td>{$order->partner_total|number_format:false:false:' '}</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td>
                    {if !$is_admin}
                        {if $order->contract->status == 1}
                            <a href="https://newres.paymart.uz/storage/contract/{$order->contract->id}/buyer_account_{$order->contract->id}.pdf"
                               target="_blank" class="btn">Распечатать АКТ</a>
                        {/if}
                    {/if}
                </td>
                <td colspan="6"></td>
                <td>
                    {if $is_admin}
                        {if $order->contract->status == 1}
                            <button class="btn tracking-contract"
                                    data-contract-id="{$order->contract->id}"
                                    data-order-id="{$order->id}">
                                {__('track_request_subj')}
                            </button>
                        {/if}
                    {else}
                        {if $order->contract->status == 2}
                            <button class="btn accept-contract"
                                    data-contract-id="{$order->contract->id}"
                                    data-order-id="{$order->id}">
                                Принять договор
                            </button>
                            <button class="btn cancel-contract"
                                    data-contract-id="{$order->contract->id}"
                                    data-order-id="{$order->id}">
                                Отменить договор
                            </button>
                        {elseif $order->contract->status == 1}
                            <button class="btn show-bar-code"
                                    data-order-id="{$order->id}">
                                {__('yml2_offer_feature_common_barcode')}
                            </button>
                            <button class="btn cancel-contract"
                                    data-contract-id="{$order->contract->id}"
                                    data-order-id="{$order->id}">
                                Отменить договор
                            </button>
                        {/if}
                    {/if}
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>