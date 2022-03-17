<div class="table-responsive-wrapper longtap-selection">
    <table class="table table-middle table--relative table-responsive">
        <thead>
        <tr>
            <th scope="col">Product name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Price</th>
            <th scope="col">Price2</th>
            <th scope="col">Tax (%)</th>
            <th scope="col">Total tax (%)</th>
            <th scope="col">Total price with tax</th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$paymart_orders->data item=order}
            <tr>
                <th scope="row">{$order->products[0]->name}</th>
                <td>{$order->products[0]->amount}</td>
                <td>{$order->products[0]->price}</td>
                <td>{$order->products[0]->price}</td>
                <td>15</td>
                <td>{$order->products[0]->amount}</td>
                <td>{$order->products[0]->amount}</td>
            </tr>
        {/foreach}

        </tbody>
    </table>
</div>