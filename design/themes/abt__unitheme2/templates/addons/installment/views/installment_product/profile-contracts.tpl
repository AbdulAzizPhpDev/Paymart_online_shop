{script src="js/addons/installment/profile-contracts.js"}
{*{fn_print_die($contracts)}*}
<div class="profile-contracts-page">
    {if !empty($contracts)}
        <h1>{__('contracts')}</h1>
        {*<div class="search-container">
            <input type="search" placeholder="Search" class="form-control search-contracts">
            <img class="search-icon" src="/design/themes/responsive/media/icons/search.svg" alt="search">
        </div>*}
        <div class="contracts">
            {foreach from=$contracts key=index item=contract}
                <div class="contract-card">
                    <div class="header">
                        <div class="info">
                            <h3>{__('contract')} № {$contract->contract_id}</h3>
                        </div>
                        <div class="status-container">
                            <span class="status-card status_{$contract->status}">{__($contract->status)}</span>
                        </div>
                    </div>
                    <p class="contract-number" data-contract-id="{$contract->contract_id}">
                        {__('gift_cert_debit')}: {$contract->remainder}
                    </p>

                    <p class="contract-date">{__('profile.contracts.next_pay')}: {$contract->next_pay}</p>
                    <div class="contract-card-footer">
                        <div class="payment">
                            <span class="sum">{$contract->monthly_payment}</span><span class="currency">Cум</span>
                        </div>
                        <div style="display: flex;align-items: center;">
                            <img class="cm-dialog-opener cm-dialog-auto-size"
                                 src="https://img.icons8.com/ios/32/000000/truck.png"
                                 data-ca-target-id="tracking-contract-modal"
                                 data-order-id="{$contract->order_id}"
                            />
                            <span style="font-size: 18px; margin-left: 16px;"
                                  class="cm-dialog-opener cm-dialog-auto-size cancelling-order"
                                  data-ca-target-id="cause-cancel-contract-modal"
                                  data-order-id="{$contract->order_id}"
                            >
                                &times;
                            </span>
                        </div>
                    </div>

                    <div class="progress active" data-percentage="{$group_by[$contract->contract_id]}"></div>
                    <div class="progress inactive"></div>
                </div>
            {/foreach}
        </div>
        {* Show Tracking Modal  *}
        <div class="hidden tracking-contract-modal" id="tracking-contract-modal" title="{__('track_my_order')}"
             data-tracking-title="{__('track_my_order')}">
            <div class="tracking-modal-body" style="overflow-y: auto"></div>
        </div>
        <div class="hidden cause-cancel-contract-modal" id="cause-cancel-contract-modal" title="Причина отказа"
             data-cause-cancel-title="Причина отказа">
            <div class="cause-cancel-modal-body" style="overflow-y: auto">
                <section class="bought-products">
                    <h3 class="ty-m-none">{__('abt__ut2.export.actions.products')}</h3>

                    <ul class="ty-mtb-xs products"></ul>
                </section>

                <section class="ty-mt-m">
                    <h3 class="ty-m-none">{__('return_registration')}</h3>

                    <div class="installment-periods ty-control-group">
                        <input class="ty-product-options__radio" value="change" type="radio" name="period" id="change" checked>
                        <label class="ty-product-options__radio--label"
                               for="change">Замена товара</label>

                        <input class="ty-product-options__radio" value="return" type="radio" name="period" id="return">
                        <label class="ty-product-options__radio--label"
                               for="return">Возврат денег</label>
                    </div>
                </section>

                <section class="ty-mt-m">
                    <h3 class="ty-m-none">{__('theme_editor.upload_image')}</h3>
                    <input class="product-photo-uploader" type="file" accept="image/*"> <br><br>
                </section>

                <section class="ty-mt-s">
                    <h3 class="ty-m-none" for="cause-text">{__('description')}</h3>
                    <textarea id="cause-text" cols="30" rows="10"></textarea>
                </section>

                <button class="ty-btn ty-btn__primary ty-mt-m return-product-btn">{__('send')}</button>
            </div>
        </div>
        {*        <div class="modal signin-modal tracking-contract-modal" style="display: none;">*}
        {*            <div class="modal-header">*}
        {*                <div><h3>Tracking Products</h3></div>*}
        {*                <button class="close-tracking-contract-modal">&times;</button>*}
        {*            </div>*}
        {*            <div class="modal-body tracking-modal-body">*}
        {*                <ul class="timeline">*}
        {*                    {__('empty')}*}
        {*                </ul>*}
        {*            </div>*}
        {*            *}{*<div class="modal-footer">*}
        {*                <button class="btn close-tracking-contract-modal">Нет</button>*}
        {*                <button class="btn confirm-tracking-contract">Да</button>*}
        {*            </div>*}
        {*        </div>*}
    {else}
        <h1 class="text-center">{__('empty')}</h1>
    {/if}
</div>