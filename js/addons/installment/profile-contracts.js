(function (_, $) {
  const $percentageActive = $('.progress.active');
  // const $searchInput = $('.search-contracts');
  // const $searchIcon = $('.search-icon');
  const $contractCards = $('.contract-card');
  const $trackingModal = $('.tracking-contract-modal');
  const $trackingModalBody = $('.tracking-modal-body');

  // const $contractNumber = $('.contract-number');

  // const profileContractsState = {
  //   order_id: null,
  // };

  const profileContractsMethods = {
    calculateProgress: function () {
      const percentage = Number($(this).data('percentage')) * 10 || 0;
      $(this).css('width', `${percentage / 12}%`);
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
      e.preventDefault();
      const orderId = $(this).data('order-id');
      const modalTitle = $trackingModal.data('tracking-title');

      $trackingModal.attr('title', modalTitle);
      profileContractsMethods.trackingContract(orderId);
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
          if (result.status === 'self') {
            const companyData = {
              address: result.address,
              phone: result.phone,
              title: result.text,
            };

            return profileContractsMethods.generateModalContent({ companyInfo: companyData, isShipping: false });
          }

          profileContractsMethods.generateModalContent({ trackingList: result.list });
        },
      });
    },
    generateModalContent: function ({ trackingList = [], companyInfo = {}, isShipping = true }) {
      const timeline = document.querySelector('.timeline');
      timeline.innerHTML = '';

      if (!isShipping) {
        timeline.classList.add('d-none');

        const selfContent = `
          <h1>${companyInfo.title}</h1>
          <div style="display: flex; align-items: center;">
              <div>
                  <svg width="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12.0001 12.7155C10.9572 12.7155 10.1083 11.8619 10.1083 10.8134C10.1083 9.76482 10.9572 8.91122 12.0001 8.91122C13.043 8.91122 13.892 9.76482 13.892 10.8134C13.892 11.8619 13.043 12.7155 12.0001 12.7155ZM11.9998 7.96022C10.4359 7.96022 9.16208 9.24021 9.16208 10.8135C9.16208 12.3867 10.4359 13.6667 11.9998 13.6667C13.5638 13.6667 14.8376 12.3867 14.8376 10.8135C14.8376 9.24021 13.5638 7.96022 11.9998 7.96022ZM16.2833 15.3446L11.9998 19.6514L7.71638 15.3446C5.35474 12.9701 5.35474 9.10635 7.71638 6.73182C8.89721 5.54377 10.4477 4.95014 11.9998 4.95014C13.5511 4.95014 15.1024 5.54456 16.2833 6.73182C18.6449 9.10635 18.6449 12.9701 16.2833 15.3446ZM16.9527 6.05902C14.2213 3.31358 9.77867 3.31358 7.04732 6.05902C4.31756 8.80447 4.31756 13.2722 7.04732 16.0176L11.6658 20.6604C11.758 20.754 11.8794 20.7999 12 20.7999C12.1206 20.7999 12.242 20.754 12.3342 20.6604L16.9527 16.0176C19.6824 13.2722 19.6824 8.80447 16.9527 6.05902Z"
                            fill="#FF7643" />
                  </svg>
              </div>
              <div>
                  <h3 class="ty-m-none">${companyInfo.address}</h3>
                  <p>${companyInfo.phone}</p>
              </div>
          </div>
        `;

        // const title = document.createElement('h1');
        // const companyAddress = document.createElement('h3');
        // const companyPhone = document.createElement('p');

        // title.textContent = companyInfo.title;
        // companyAddress.textContent = companyInfo.address;
        // companyPhone.textContent = companyInfo.phone;

        $trackingModalBody.append(selfContent);
        // $trackingModalBody.append(companyAddress);
        // $trackingModalBody.append(companyPhone);

        return;
      }

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