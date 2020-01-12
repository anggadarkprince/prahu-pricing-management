import variables from "../components/variables";
import showAlert from "../components/alert";
import formatter from "../components/formatter";

export default function () {

	/**
	 * url: /pricing/calculator/{create/({edit/:id})}
	 * Manage form calculator of pricing.
	 */
	const formCalculator = $('#form-calculator');
	const selectLocationOrigin = formCalculator.find('#location_origin');
	const selectLocationDestination = formCalculator.find('#location_destination');
	const selectPortOrigin = formCalculator.find('#port_origin');
	const selectPortDestination = formCalculator.find('#port_destination');
	const selectContainerSize = formCalculator.find('#container_size');
	const selectContainerType = formCalculator.find('#container_type');
	const selectPaymentType = formCalculator.find('#payment_type');
	const selectService = formCalculator.find('#service');
	const selectIncomeTax = formCalculator.find('#income_tax');
	const selectInsurance = formCalculator.find('#insurance');
	const inputGoodsValue = formCalculator.find('#goods_value');
	const pricingWrapper = formCalculator.find('#pricing-wrapper');
	let margin = 0;

	selectService.on('change', function () {
		const query = $.param({
			id_service: $(this).val(),
		});
		fetch(variables.baseUrl + 'master/service/ajax-get-service?' + query)
			.then(result => result.json())
			.then(data => {
				pricingWrapper.find('.row-component').addClass('table-secondary');
				pricingWrapper.find('.select-package').val('').trigger('change').prop('disabled', true);
				pricingWrapper.find('.select-vendor').val('').trigger('change').prop('disabled', true);
				pricingWrapper.find('.input-component-price').val('');
				pricingWrapper.find('.btn-reveal-price')
					.removeClass('btn-outline-danger')
					.addClass('btn-outline-secondary')
					.prop('disabled', true);
				if (data.service_components) {
					data.service_components.forEach(component => {
						const componentRow = pricingWrapper.find(`.row-component[data-component-id="${component.id_component}"]`);
						componentRow.removeClass('table-secondary');
						componentRow.find('.select-package').prop('disabled', false);
						componentRow.find('.select-vendor').prop('disabled', false);
						componentRow.find('.input-component-price').text('Rp. 0');
						componentRow.find('.btn-reveal-price')
							.addClass('btn-outline-danger')
							.removeClass('btn-outline-secondary')
							.prop('disabled', false);
					});
				}
			})
			.catch(error => {
				showAlert('Error Fetching Data', 'Get data service failed, please try again!', error.message);
			});
	});


	formCalculator.on('change', '#service, #payment_type', function () {
		if (selectService.val() && selectPaymentType.val()) {
			const query = $.param({
				'service': selectService.val(),
				'payment_type': selectPaymentType.val(),
			});
			fetch(variables.baseUrl + 'pricing/calculator/ajax-get-margin?' + query)
				.then(result => result.json())
				.then(data => {
					margin = 0;
					if (data) {
						margin = Number(data.margin_percent);
					}
					calculatePrice();
				})
				.catch(error => {
					showAlert('Error Fetching Margin', 'Get service margin failed, please try again!', error.message);
				});
		}
	});

	selectInsurance.on('change', function () {
		if ($(this).val() === '1') {
			inputGoodsValue.prop('readonly', false).prop('required', true);
		} else {
			inputGoodsValue.val('').prop('readonly', true).prop('required', false);
			pricingWrapper.find('.input-insurance-price').val('');
		}
		calculatePrice();
	});

	inputGoodsValue.on('input change', function () {
		let goodsValue = formatter.getNumberValue(inputGoodsValue.val() || 0);
		if (goodsValue < 125000000) {
			goodsValue = 125000000;
		}
		const insurance = (0.08 / 100 * goodsValue) + 25000;
		pricingWrapper.find('.input-insurance-price').val(formatter.setNumberValue(insurance, 'Rp. '));
		calculatePrice();
	});

	selectIncomeTax.on('change', function () {
		calculatePrice();
	});

	pricingWrapper.on('change', '.select-package, .select-vendor', function () {
		const rowComponent = $(this).closest('.row-component');
		if (rowComponent.find('.select-vendor').val() && rowComponent.find('.select-package').val() && selectContainerSize.val() && selectContainerType.val()) {
			rowComponent.find('.input-component-price').val('Calculating...');
			const query = $.param({
				'component': rowComponent.data('component-id'),
				'vendor': rowComponent.find('.select-vendor').val(),
				'port_origin': selectPortOrigin.val(),
				'port_destination': selectPortDestination.val(),
				'location_origin': selectLocationOrigin.val(),
				'location_destination': selectLocationDestination.val(),
				'container_size': selectContainerSize.val(),
				'container_type': selectContainerType.val(),
				'package': rowComponent.find('.select-package').val(),
			});
			fetch(variables.baseUrl + 'pricing/calculator/ajax-get-component-price?' + query)
				.then(result => result.json())
				.then(data => {
					let price = 0;
					if (data.length) {
						price = Number(data[0].price);
					}
					rowComponent.find('.input-component-price').val(formatter.setNumberValue(price, 'Rp. ')).change();
				})
				.catch(error => {
					rowComponent.find('.input-component-price').val('Rp. 0');
					showAlert('Error Fetching Component', 'Get price data failed, please try again!', error.message);
				});
		}
	});

	pricingWrapper.on('change', '.select-packaging', function () {
		const rowPackaging = $(this).closest('.row-packaging');
		if (rowPackaging.find('.select-packaging').val() && selectContainerSize.val()) {
			rowPackaging.find('.input-packaging-price').val('Calculating...');
			const query = $.param({
				'type': 'PACKAGING',
				'consumable': rowPackaging.find('.select-packaging').val(),
				'container_size': selectContainerSize.val(),
			});
			fetch(variables.baseUrl + 'pricing/calculator/ajax-get-consumable-price?' + query)
				.then(result => result.json())
				.then(data => {
					let price = 0;
					if (data) {
						price = Number(data.price);
					}
					rowPackaging.find('.input-packaging-price').val(formatter.setNumberValue(price, 'Rp. ')).change();
				})
				.catch(error => {
					rowPackaging.find('.input-component-price').val('Rp. 0');
					showAlert('Error Fetching Packaging', 'Get packaging price failed, please try again!', error.message);
				});
		}
	});

	/**
	 * Add additional packaging row
	 */
	const packagingTemplate = $('#packaging-template').html();
	pricingWrapper.on('click', '.btn-add-packaging', function (e) {
		e.preventDefault();

		const pricingItem = $(this).closest('.pricing-item');
		if (pricingItem.find('.row-packaging').length >= 5) {
			showAlert('Packaging restriction', 'Maximum additional package are 5 items', 'Please review your inputs');
		} else {
			pricingItem.find('.row-packaging').last().after(packagingTemplate);

			pricingItem.find('.select2').select2({
				minimumResultsForSearch: 10,
				placeholder: 'Select data'
			}).on("select2:open", function () {
				$(".select2-search__field").attr("placeholder", "Search...");
			}).on("select2:close", function () {
				$(".select2-search__field").attr("placeholder", null);
			});
		}
	});

	/**
     * Remove row item of packaging
     */
	pricingWrapper.on('click', '.btn-remove-packaging', function (e) {
		e.preventDefault();

		$(this).closest('.additional-package').remove();

		calculatePrice();
	});

	/**
	 * Add additional surcharge row
	 */
	const surchargeTemplate = $('#surcharge-template').html();
	pricingWrapper.on('click', '.btn-add-surcharge', function (e) {
		e.preventDefault();
		const pricingItem = $(this).closest('.pricing-item');
		if (pricingItem.find('.row-surcharge').length >= 5) {
			showAlert('Surcharge restriction', 'Maximum additional surcharge are 5 items', 'Please review your inputs');
		} else {
			pricingItem.find('.row-surcharge').last().after(surchargeTemplate);
		}
	});

	/**
     * Remove row item of surcharge
     */
	pricingWrapper.on('click', '.btn-remove-surcharge', function (e) {
		e.preventDefault();

		$(this).closest('.additional-surcharge').remove();

		calculatePrice();
	});


	pricingWrapper.on('change input', '.input-component-price, .input-surcharge-price, .input-packaging-price, .input-insurance-price', function (e) {
		calculatePrice();
	});

	function calculatePrice() {
		Array.from(pricingWrapper.find('.pricing-item')).forEach(function (pricingItem) {
			let totalComponentPrice = 0;
			let totalPackagingPrice = 0;
			let totalSurchargePrice = 0;
			const insurance = formatter.getNumberValue($(pricingItem).find('.input-insurance-price').val() || 0);

			Array.from($(pricingItem).find('.input-component-price')).forEach(function (inputComponentPrice) {
				totalComponentPrice += formatter.getNumberValue($(inputComponentPrice).val() || 0);
			});
			Array.from($(pricingItem).find('.input-packaging-price')).forEach(function (inputPackagingPrice) {
				totalPackagingPrice += formatter.getNumberValue($(inputPackagingPrice).val() || 0);
			});
			Array.from($(pricingItem).find('.input-surcharge-price')).forEach(function (inputSurchargePrice) {
				totalSurchargePrice += formatter.getNumberValue($(inputSurchargePrice).val() || 0);
			});
			const totalPurchase = totalComponentPrice + totalPackagingPrice + totalSurchargePrice + insurance;
			const totalSellBeforeTax = totalPurchase + (margin / 100 * totalPurchase);

			let tax = 0;
			if (selectIncomeTax.val() == 1) {
				tax = 0.2 * totalSellBeforeTax;
			}
			const totalSellAfterTax = totalSellBeforeTax + tax;

			$(pricingItem).find('.label-purchase-amount').text(formatter.setNumberValue(totalPurchase, 'Rp. '));
			$(pricingItem).find('.label-sell-before-tax').text('(' + formatter.setNumberValue(margin) + '%) ' + formatter.setNumberValue(totalSellBeforeTax, 'Rp. '));
			$(pricingItem).find('.label-sell-after-tax').text(formatter.setNumberValue(totalSellAfterTax, 'Rp. '));

		});
	}

};
