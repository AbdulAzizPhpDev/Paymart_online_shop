{script src="js/addons/installment/profile-contracts.js"}

<div class="profile-contracts-page">
    <h1>Договора</h1>
    <div class="search-container">
        <input type="search" placeholder="Search" class="form-control">
        <img src="/design/themes/responsive/media/icons/search.svg" alt="search">
    </div>

    <div class="contracts">
        {foreach from=$contract_statuses key=number item=text}
            <div class="contract-card">
                <div class="header">
                    <div class="info">
                        <h3>Стиральная машина</h3>
                    </div>
                    <div class="status-container">
                        <span class="status-card status-{$number}">{$text}</span>
                    </div>
                </div>
                <p>Договор #12/12</p>

                <p class="contract-date">Следующая выплата: 15.04.2020</p>
                <span class="sum">500 000.00</span><span class="currency">Cум</span>
            </div>
        {/foreach}
    </div>
</div>