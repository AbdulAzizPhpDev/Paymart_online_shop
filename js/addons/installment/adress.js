(function (_, $) {
  const $regions = $('.city-regions');
  const defaultSelectedCity = $('#formAddress__select :selected').val();
  const $deliveryDateContainer = $('.delivery-date__days');

  const addressState = {
    deliveryDays: 2,
    totalDeliveryDays: 0,
  };

  const addressMethods = {
    calculateDeliveryDate: function (deliveryDay, extraDay = 0) {
      const now = new Date();
      const deliveryDate = now.addDays(deliveryDay + extraDay);

      addressState.totalDeliveryDays = deliveryDay + extraDay;

      const extraDeliveryDate = deliveryDate.addDays(2).toLocaleDateString();
      const labelDelivery = `${deliveryDate.toLocaleDateString()} - ${extraDeliveryDate}`;

      $deliveryDateContainer.text(labelDelivery);

    },
    getRegions: function (cityId = null) {
      $.ceAjax('request', fn_url('get_city.city'), {
        method: 'post',
        data: {
          city_id: cityId || defaultSelectedCity,
        },
        callback: function (response) {
          if (response.result == null) {
            alert('response null');
            return false;
          }

          addressMethods.calculateDeliveryDate(addressState.deliveryDays, 0);

          $regions.empty();
          response.result.forEach(number => {
            const option = `<option value="${number.city_id}" data-extra-days="${number.extra_days}">${number.city_name}</option>`;
            $regions.append(option);
          });
        },
      });
    },
    onSelectCity: function (event) {
      const selectedCityId = event.target.value;
      addressState.deliveryDays = $(this).find(':selected').data('delivery-days') || 0;

      addressMethods.calculateDeliveryDate(addressState.deliveryDays, 0);

      addressMethods.getRegions(selectedCityId);
    },
    onSelectRegion: function () {
      const extraDays = $(this).find(':selected').data('extra-days');

      addressMethods.calculateDeliveryDate(addressState.deliveryDays, extraDays);
    },
  };

  $('#formAddress__select').on('change', addressMethods.onSelectCity);

  $regions.on('change', addressMethods.onSelectRegion);

  addressMethods.getRegions();

  Date.prototype.addDays = function (days) {
    const date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
  };

})(Tygh, Tygh.$);