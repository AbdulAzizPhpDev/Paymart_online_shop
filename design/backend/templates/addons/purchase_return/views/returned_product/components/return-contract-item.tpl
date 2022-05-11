<div class="order">
    <div class="head">
        <div class="info">
            <div class="contract-info">
                <h3>Договор клиента № {$order['contract_id']}</h3>
                <p>от {$order->contract->created_at} 13.04.2022</p>
            </div>
            <div class="buyer-info">
                {if $order->buyer->name != null}
                    <h3>{$order->buyer->surname} {$order->buyer->name} {$order->buyer->patronymic}</h3>
                {else}
                    <h3>Robert Fox (Test name)</h3>
                {/if}
                <p>Тел: {*{$order->buyer->phone}*}+998 99 819-88-24</p>
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
                {*                <th scope="col">Клиент</th>*}
                {*                <th scope="col">Вендор</th>*}
                {*                <th scope="col">Сумма НДС</th>*}
                {*                <th scope="col">Всего с НДС</th>*}
            </tr>
            </thead>
            <tbody>
            {foreach $order['image'] as $product_data}
                <tr>
                    <td>
                        <img src="https://www.creditasia.uz/upload/iblock/956/smartfon-samsung-galaxy-s21-sm-g991b-ds-128gb-violet-1.jpg"
                             alt=""
                             width="80"
                        >
                        {$product_data['path']}
                    </td>
                    <td>Смартфон SAMSUNG Galaxy S21 SM-G991B/DS (128GB) Violet</td>
                    <td>2</td>
                    <td>25000</td>
                    <td>50000</td>
                    {*                    <td rowspan="3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. A atque autem consequatur*}
                    {*                        debitis nostrum, porro sequi? Architecto aspernatur, consequuntur culpa, esse illum, magnam*}
                    {*                        minus*}
                    {*                        non omnis quia sit suscipit tenetur?*}
                    {*                    </td>*}
                    {*                    <td rowspan="3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. A atque autem consequatur*}
                    {*                        debitis nostrum, porro sequi? Architecto aspernatur, consequuntur culpa, esse illum, magnam*}
                    {*                        minus*}
                    {*                        non omnis quia sit suscipit tenetur?*}
                    {*                    </td>*}
                </tr>
            {/foreach}
            {*{foreach from=$order->products item=product}
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
            {/foreach}*}
            <tr class="total-price">
                <td colspan="4">Итого</td>
                <td>75400</td>
                {*                <td></td>*}
                {*                {if $is_admin}*}
                {*                    <td>{$order->contract->total|number_format:false:false:' '}</td>*}
                {*                {else}*}
                {*                    <td>{$order->partner_total|number_format:false:false:' '}</td>*}
                {*                {/if}*}
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5"></td>
            </tr>
            </tfoot>
        </table>

        <section class="comments">
            <h1>Комментарии</h1>

            <div class="row-fluid">
                <div class="span6">
                    <h4>Клиент</h4>
                    <p>{$order['client']['description']}</p>
                </div>
                <div class="span6">
                    <h4>Вендор</h4>
                    <p>{$order['vendor']['description']}</p>
                </div>
            </div>
        </section>

        <div style="text-align: right;">
            <button class="btn return-accept-btn" data-contract-id="23" data-order-id="12">
                {__('accept')}
            </button>
            <button class="btn return-cancel-btn" data-contract-id="32" data-order-id="21">
                {__('decline')}
            </button>
            {*            <button class="btn tracking-contract"*}
            {*                    data-contract-id="23"*}
            {*                    data-order-id="12"*}
            {*            >*}
            {*                {__('accept')}*}
            {*            </button>*}
        </div>
    </div>
</div>