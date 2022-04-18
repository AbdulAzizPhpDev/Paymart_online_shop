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
      $trackingModalBody.html('');

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

          profileContractsMethods.generateModalContent({ trackingList: result.list.reverse() });
        },
      });
    },
    generateModalContent: function ({ trackingList = [], companyInfo = {}, isShipping = true }) {
      if (!isShipping) {
        const selfContent = `
          <h1>${companyInfo.title}</h1>
          
          <div style="display: flex; align-items: center;">
            <svg width="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M12.0001 12.7155C10.9572 12.7155 10.1083 11.8619 10.1083 10.8134C10.1083 9.76482 10.9572 8.91122 12.0001 8.91122C13.043 8.91122 13.892 9.76482 13.892 10.8134C13.892 11.8619 13.043 12.7155 12.0001 12.7155ZM11.9998 7.96022C10.4359 7.96022 9.16208 9.24021 9.16208 10.8135C9.16208 12.3867 10.4359 13.6667 11.9998 13.6667C13.5638 13.6667 14.8376 12.3867 14.8376 10.8135C14.8376 9.24021 13.5638 7.96022 11.9998 7.96022ZM16.2833 15.3446L11.9998 19.6514L7.71638 15.3446C5.35474 12.9701 5.35474 9.10635 7.71638 6.73182C8.89721 5.54377 10.4477 4.95014 11.9998 4.95014C13.5511 4.95014 15.1024 5.54456 16.2833 6.73182C18.6449 9.10635 18.6449 12.9701 16.2833 15.3446ZM16.9527 6.05902C14.2213 3.31358 9.77867 3.31358 7.04732 6.05902C4.31756 8.80447 4.31756 13.2722 7.04732 16.0176L11.6658 20.6604C11.758 20.754 11.8794 20.7999 12 20.7999C12.1206 20.7999 12.242 20.754 12.3342 20.6604L16.9527 16.0176C19.6824 13.2722 19.6824 8.80447 16.9527 6.05902Z"
                      fill="#FF7643" />
            </svg>
            <strong>${companyInfo.address}</strong>
          </div>
          
          <div style="display: flex; align-items: center;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" 
                d="M13.3335 18.0893C13.3335 18.5589 12.9601 18.9384 12.5001 18.9384C12.0401 18.9384 11.6668 18.5589 11.6668 18.0893C11.6668 17.6198 12.0401 17.2402 12.5001 17.2402C12.9601 17.2402 13.3335 17.6198 13.3335 18.0893ZM13.8332 5.63135C13.8332 5.91325 13.6099 6.14081 13.3332 6.14081H11.6666C11.3899 6.14081 11.1666 5.91325 11.1666 5.63135C11.1666 5.34945 11.3899 5.12274 11.6666 5.12274H13.3332C13.6099 5.12274 13.8332 5.34945 13.8332 5.63135ZM17.0001 18.7923C17.0001 19.4478 16.4768 19.9819 15.8334 19.9819H9.16677C8.52344 19.9819 8.00011 19.4478 8.00011 18.7923V5.20679C8.00011 4.55214 8.52344 4.01806 9.16677 4.01806H15.8334C16.4768 4.01806 17.0001 4.55214 17.0001 5.20679V18.7923ZM15.8333 3H9.16667C7.97167 3 7 3.99005 7 5.2068V18.7924C7 20.01 7.97167 21 9.16667 21H15.8333C17.0283 21 18 20.01 18 18.7924V5.2068C18 3.99005 17.0283 3 15.8333 3Z" 
                fill="#FF7643"/>
            </svg>
            <span>${companyInfo.phone}</span>
          </div>
        `;

        return $trackingModalBody.append(selfContent);
      }

      const timeline = document.createElement('ul');
      timeline.classList.add('timeline');

      trackingList.forEach(({ status, date }) => {
        const li = document.createElement('li');
        const eventDate = new Date(date);

        li.classList.add('event');
        li.setAttribute('data-date', eventDate.toLocaleString());
        li.innerHTML = `<h3>${status}</h3>`;

        timeline.appendChild(li);
      });

      $trackingModalBody.append(timeline);
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