{script src="js/addons/installment/profile-contracts.js"}

<div class="profile-contracts-page">
    <h1>Договора</h1>
    <div class="search-container">
        <input type="search" placeholder="Search" class="form-control search-contracts">
        <img class="search-icon" src="/design/themes/responsive/media/icons/search.svg" alt="search">
    </div>

    <div class="contracts">
        {if !empty($contracts)}
            {foreach from=$contracts->contracts key=index item=contract}
                <a href="https://paymart.uz/ru/contract/{$contract->contract_id}" target="_blank" class="contract-card">
                    <div class="header">
                        <div class="info">
                            <h3>Стиральная машина</h3>
                        </div>
                        <div class="status-container">
                            <span class="status-card status-{$contract->status}">status {$contract->status}</span>
                        </div>
                    </div>
                    <p class="contract-number" data-contract-id="{$contract->contract_id}">Договор
                        № {$contract->contract_id}</p>

                    <p class="contract-date">Следующая выплата: {$contract->next_pay}</p>
                    <span class="sum">{$contract->monthly_payment}</span><span class="currency">Cум</span>

                    <div class="progress active" data-percentage="{$group_by[$contract->contract_id]}"></div>
                    <div class="progress inactive"></div>
                </a>
            {/foreach}
        {else}
            <h3>Пусто</h3>
        {/if}
    </div>
</div>