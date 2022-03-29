(function (_, $) {
  const $percentageActive = $('.progress.active');
  // const $searchInput = $('.search-contracts');
  // const $searchIcon = $('.search-icon');
  const $contractCards = $('.contract-card');
  const $trackingModal = $('.tracking-contract-modal');

  // const $contractNumber = $('.contract-number');

  // const profileContractsState = {
  //   order_id: null,
  // };

  const profileContractsMethods = {
    calculateProgress: function () {
      const percentage = Number($(this).data('percentage')) * 10 || 0;
      $(this).css('width', `${percentage}%`);
    },
    // searchContract: function (event) {
    //   const searchValue = $searchInput.val();
    //
    //   switch (true) {
    //     case event.keyCode === 13 :
    //       console.log('searching with enter ...', searchValue);
    //       $searchInput.val('');
    //       break;
    //     case event.handleObj.type === 'click':
    //       console.log('searching with mouse event', searchValue);
    //       $searchInput.val('');
    //       break;
    //   }
    // },
    handleCard: function () {
      $(this).on('click', profileContractsMethods.showTrackingModal);
    },
    showTrackingModal: function (e) {
      if (e.target.tagName === 'IMG') {
        e.preventDefault();
        const orderId = $(this).data('order-id');
        const modalTitle = $trackingModal.data('tracking-title');
        // console.log(modalTitle);
        $trackingModal.attr('title', modalTitle);
        profileContractsMethods.trackingContract(orderId);
      }
    },
    trackingContract: function (order_id) {
      $.ceAjax('request', fn_url('installment_orders.order_tracking'), {
        method: 'POST',
        data: {
          order_id,
        },
        callback: function (response) {
          if (!response.hasOwnProperty('result')) {
            return document.querySelector('.timeline').innerText = _.tr('empty');
          }

          const { result } = response;

            profileContractsMethods.generateModalContent(result.list);
        },
      });
    },
    generateModalContent: function (trackingList = []) {
      const timeline = document.querySelector('.timeline');
      timeline.innerHTML = '';

      trackingList.forEach(({ status, date }) => {
        const li = document.createElement('li');
        const eventDate = new Date(date);

        li.classList.add('event');
        li.setAttribute('data-date', eventDate.toLocaleString());
        li.innerHTML = `<h3>${status}</h3>`;

        timeline.appendChild(li);
      });
    },
  };

  $percentageActive.each(profileContractsMethods.calculateProgress);
  $contractCards.each(profileContractsMethods.handleCard);
  // $searchIcon.on('click', profileContractsMethods.searchContract);
  // $searchInput.on('keyup', profileContractsMethods.searchContract);

  // $('.close-tracking-contract-modal').on('click', function () {
  //   $trackingModal.modal('hide');
  // });
})(Tygh, Tygh.$);