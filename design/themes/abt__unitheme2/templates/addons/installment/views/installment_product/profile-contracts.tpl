{script src="js/addons/installment/profile-contracts.js"}

<div class="profile-contracts-page">
    {if !empty($contracts)}
        <h1>{__('contracts')}</h1>
        {*<div class="search-container">
            <input type="search" placeholder="Search" class="form-control search-contracts">
            <img class="search-icon" src="/design/themes/responsive/media/icons/search.svg" alt="search">
        </div>*}
        <div class="contracts">
            {foreach from=$contracts key=index item=contract}
                <a href="https://front.paymart.uz/{$smarty.const.CART_LANGUAGE|lower}/market/contract/{$contract->contract_id}?api_token={$user_api_token}&user_phone={$user_phone}"
                   target="_blank" class="contract-card">
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
                        {if $contract->status == 'active'}
                            <img src="https://img.icons8.com/ios/32/000000/truck.png" />
                        {/if}
                    </div>

                    <div class="progress active" data-percentage="{$group_by[$contract->contract_id]}"></div>
                    <div class="progress inactive"></div>
                </a>
            {/foreach}
        </div>
    {else}
        <h1 class="text-center">{__('empty')}</h1>
    {/if}
</div>