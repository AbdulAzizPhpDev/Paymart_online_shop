(function (_, $) {
  const $percentageActive = $('.progress.active');
  const $searchInput = $('.search-contracts');
  const $searchIcon = $('.search-icon');
  const $contractCards = $('.contract-card');
  // const $contractNumber = $('.contract-number');

  // const contractsState = {
  //   contractIds: [],
  // };

  const contractsMethods = {
    calculateProgress: function () {
      const percentage = Number($(this).data('percentage')) * 10 || 0;
      $(this).css('width', `${percentage}%`);
    },
    searchContract: function (event) {
      const searchValue = $searchInput.val();

      switch (true) {
        case event.keyCode === 13 :
          console.log('searching with enter ...', searchValue);
          $searchInput.val('');
          break;
        case event.handleObj.type === 'click':
          console.log('searching with mouse event', searchValue);
          $searchInput.val('');
          break;
      }
    },
    handleCard: function () {
      $(this).on('click', contractsMethods.onChooseCard)
    },
    onChooseCard: function (e) {
      if (e.target.tagName === 'IMG') {
        e.preventDefault();
        alert('Tracking contracts displays soon!')
      }
    }
  };

  $percentageActive.each(contractsMethods.calculateProgress);
  $contractCards.each(contractsMethods.handleCard)
  $searchIcon.on('click', contractsMethods.searchContract);
  $searchInput.on('keyup', contractsMethods.searchContract);
})(Tygh, Tygh.$);