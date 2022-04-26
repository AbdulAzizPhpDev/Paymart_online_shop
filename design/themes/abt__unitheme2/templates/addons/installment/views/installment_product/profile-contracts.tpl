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
            <div class="cause-cancel-modal-body" style="overflow-y: auto"></div>
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