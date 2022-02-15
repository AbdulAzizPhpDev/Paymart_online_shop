{script src="js/addons/installment/profile-contracts.js"}

<div class="profile-contracts-page">
    <h1>Договора</h1>
    <div class="search-container">
        <input type="search" placeholder="Search" class="form-control">
        <img src="/design/themes/responsive/media/icons/search.svg" alt="search">
    </div>

    <div class="contracts">
        {if !empty($contracts)}
            {foreach from=$contracts->contracts key=index item=contract}
                <div class="contract-card">
                    <div class="header">
                        <div class="info">
                            <h3>Стиральная машина</h3>
                        </div>
                        <div class="status-container">
                            <span class="status-card status-{$contract->status}">status {$contract->status}</span>
                        </div>
                    </div>
                    <p>Договор {$contract->id}</p>

                    <p class="contract-date">Следующая выплата: {$contract->next_pay}</p>
                    <span class="sum">{$contract->monthly_payment}</span><span class="currency">Cум</span>
                    <div class="progress active" data-percentage="{$index}0"></div>
                    <div class="progress inactive"></div>
                </div>
            {/foreach}
        {/if}
    </div>
</div>