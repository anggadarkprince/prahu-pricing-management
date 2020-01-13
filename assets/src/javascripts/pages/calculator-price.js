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
	const selectPackaging = formCalculator.find('#packaging');
	const selectIncomeTax = formCalculator.find('#income_tax');
	const selectInsurance = formCalculator.find('#insurance');
	const inputGoodsValue = formCalculator.find('#goods_value');
	const pricingWrapper = formCalculator.find('#pricing-wrapper');
	let serviceComponentSetting = [];
	let margin = 0;

	selectService.on('change', function () {
		const query = $.param({
			id_service: $(this).val(),
		});
		fetch(variables.baseUrl + 'master/service/ajax-get-service?' + query)
			.then(result => result.json())
			.then(data => {
				if (data.service_components) {
					serviceComponentSetting = data.service_components;
				}
				setupComponentActive();
			})
			.catch(error => {
				showAlert('Error Fetching Data', 'Get data service failed, please try again!', error.message);
			});
	});

	function setupComponentActive() {
		pricingWrapper.find('.row-component').addClass('table-secondary');
		pricingWrapper.find('.select-package').val('').trigger('change').prop('disabled', true);
		pricingWrapper.find('.row-component:not([data-service-section="SHIPPING"]) .select-vendor').val('').trigger('change').prop('disabled', true);
		pricingWrapper.find('.row-component:not([data-service-section="SHIPPING"]) .input-vendor').val('').prop('disabled', true);
		pricingWrapper.find('.input-component-price').val('').prop('disabled', true);
		pricingWrapper.find('.btn-reveal-price')
			.removeClass('btn-outline-danger')
			.addClass('btn-outline-secondary')
			.prop('disabled', true);
		serviceComponentSetting.forEach(component => {
			const componentRow = pricingWrapper.find(`.row-component[data-component-id="${component.id_component}"]`);
			componentRow.removeClass('table-secondary');
			componentRow.find('.select-package').prop('disabled', false);
			//componentRow.find('.select-vendor').prop('disabled', false);
			componentRow.find('.input-vendor').prop('disabled', false);
			componentRow.find('.input-component-price').text('Rp. 0').prop('disabled', false);
			componentRow.find('.btn-reveal-price')
				.addClass('btn-outline-danger')
				.removeClass('btn-outline-secondary')
				.prop('disabled', false);
		});
	}

	const pricingTemplate = $('#pricing-template').html();
	formCalculator.on('change', '#shipping_line', function () {
		const shippingLineId = $(this).val();
		if (shippingLineId == 0) {
			pricingWrapper.empty();
			formCalculator.find('#shipping_line option').each((index, item) => {
				if ($(item).attr('value') != '' && $(item).attr('value') != '0') {
					pricingWrapper.append(
						pricingTemplate
							.replace(/{{id}}/g, $(item).attr('value'))
							.replace(/{{title}}/g, ($(item).text() + ' Pricing').toUpperCase())
					);
					pricingWrapper.find(`.pricing-item[data-id=${$(item).attr('value')}] .row-component[data-service-section=SHIPPING] .select-vendor`)
						.val($(item).attr('value'))
						.trigger('change');
					pricingWrapper.find(`.pricing-item[data-id=${$(item).attr('value')}] .row-component[data-service-section=SHIPPING] .input-vendor`)
						.val($(item).attr('value'));
				}
			});
		} else {
			pricingWrapper.html(
				pricingTemplate
					.replace(/{{id}}/g, shippingLineId)
					.replace(/{{title}}/g, ($(this).find('option:selected').text() + ' Pricing').toUpperCase())
			);
			pricingWrapper.find(`.pricing-item[data-id=${shippingLineId}] .row-component[data-service-section=SHIPPING] .select-vendor`)
				.val(shippingLineId)
				.trigger('change');
			pricingWrapper.find(`.pricing-item[data-id=${shippingLineId}] .row-component[data-service-section=SHIPPING] .input-vendor`)
				.val(shippingLineId);
		}

		pricingWrapper.find('.select2').select2({
			minimumResultsForSearch: 10,
			placeholder: 'Select data'
		}).on("select2:open", function () {
			$(".select2-search__field").attr("placeholder", "Search...");
		}).on("select2:close", function () {
			$(".select2-search__field").attr("placeholder", null);
		});

		selectPackaging.trigger('change');
		inputGoodsValue.trigger('change');
		reorderRow();
		setupComponentActive();
	});

	selectPackaging.on('change', function () {
		if($(this).val() == 1) {
			formCalculator.find('.select-packaging').prop('disabled', false);
		} else {
			formCalculator.find('.row-packaging.additional-package').remove();
			formCalculator.find('.select-packaging').val('').trigger('change').prop('disabled', true);
			formCalculator.find('.input-packaging-price').val('');
		}
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

	let durationCharges = {
		from: {},
		to: {},
		charge: []
	};
	formCalculator.on('change', '#activity_duration_from, #activity_duration_to', function () {
		const durationSection = $(this).prop('id') == 'activity_duration_from' ? 'from' : 'to';
		const query = $.param({
			'type': 'ACTIVITY DURATION',
			'consumable': $(this).val(),
			'container_size': selectContainerSize.val(),
		});
		fetch(variables.baseUrl + 'pricing/calculator/ajax-get-consumable-price?' + query)
			.then(result => result.json())
			.then(data => {
				if (data && data.components) {
					durationCharges[durationSection] = data;
				} else {
					durationCharges[durationSection] = [];
				}

			})
			.catch(error => {
				console.log(error.message);
			});
	});

	formCalculator.on('change', '#port_origin, #port_destination, #location_origin, #location_destination, #container_size, #container_type', function () {
		if (selectContainerSize.val()) {
			if(selectContainerType.val()) {
				const selectPackages = pricingWrapper.find('.row-component .select-package:enabled');
				selectPackages.each(function (index, selectPackage) {
					if ($(selectPackage).val()) {
						$(selectPackage).trigger('change');
					}
				});
			}
			formCalculator.find('.select-packaging').trigger('change');
		}
	});

	pricingWrapper.on('change', '.select-package', function () {
		const rowComponent = $(this).closest('.row-component');
		if (rowComponent.find('.select-package').val() && selectContainerSize.val() && selectContainerType.val()) {
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
				'autoselect': rowComponent.data('service-section') == 'SHIPPING' ? '' : 'lowest-price'
			});
			fetch(variables.baseUrl + 'pricing/calculator/ajax-get-component-price?' + query)
				.then(result => result.json())
				.then(data => {
					let price = 0;
					if (data.length) {
						if (rowComponent.data('service-section') != 'SHIPPING') {
							rowComponent.find('.select-vendor').val(data[0].id_vendor).trigger('change');
							rowComponent.find('.input-vendor').val(data[0].id_vendor);
						}
						price = Number(data[0].price);
					} else {
						if (rowComponent.data('service-section') != 'SHIPPING') {
							rowComponent.find('.select-vendor').val('').trigger('change');
							rowComponent.find('.input-vendor').val('');
						}
						showAlert('No Price Available', 'No active vendor price available!', 'Check setting above or price expiration');
					}
					rowComponent.find('.input-component-price').val(formatter.setNumberValue(price, 'Rp. ')).change();
				})
				.catch(error => {
					rowComponent.find('.input-component-price').val('Rp. 0');
					showAlert('Error Fetching Component', 'Get price data failed, please try again!', error.message);
				});
		}
	});

	const componentDetailTemplate = $('#component-detail-template').html();
	pricingWrapper.on('click', '.btn-reveal-price', function () {
		const rowComponent = $(this).closest('.row-component');
		if (rowComponent.next('.row-component-detail').length) {
			$(this).addClass('btn-outline-danger').removeClass('btn-danger');
			$(this).find('i').addClass('mdi-magnify').removeClass('mdi-eye-off-outline');
			rowComponent.next('.row-component-detail').remove();
		} else {
			const totalComponentPrice = formatter.getNumberValue(rowComponent.find('.input-component-price').val());
			if(rowComponent.find('.select-vendor').val() && rowComponent.find('.select-package').val() && totalComponentPrice > 0) {
				$(this).addClass('btn-danger').removeClass('btn-outline-danger');
				$(this).find('i').addClass('mdi-eye-off-outline').removeClass('mdi-magnify');
				rowComponent.after(componentDetailTemplate);
				const rowComponentDetail = rowComponent.next('.row-component-detail');
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
					'detail': true,
				});
				fetch(variables.baseUrl + 'pricing/calculator/ajax-get-component-price?' + query)
					.then(result => result.json())
					.then(data => {
						rowComponentDetail.find('tbody').empty();
						data.component_prices.forEach((componentPrice, index) => {
							rowComponentDetail.find('tbody').append(`
								<tr>
									<td class="text-md-center">${index + 1}</td>
									<td>${componentPrice.sub_component}</td>
									<td class="text-md-right">${formatter.setNumberValue(componentPrice.price, 'Rp. ')}</td>
								</tr>
							`);
						});
						const totalDp = data.vendor.term_payment / 100 * totalComponentPrice;
						rowComponentDetail.find('.partner-info').text(data.vendor.vendor);
						rowComponentDetail.find('.partner-term-payment').text(data.vendor.term_payment + '%');
						rowComponentDetail.find('.partner-total-payment').text(formatter.setNumberValue(totalComponentPrice, 'Rp. '));
						rowComponentDetail.find('.partner-total-dp').text(formatter.setNumberValue(totalDp, 'Rp. '));
						rowComponentDetail.find('.partner-payment-left').text(formatter.setNumberValue(totalComponentPrice - totalDp, 'Rp. '));
					})
					.catch(error => {
						rowComponentDetail.find('tbody').empty();
						showAlert('Error Fetching Detail', 'Get detail data failed, please try again!', error.message);
					});
			} else {
				showAlert('Cannot Show Detail', 'Component price not available, pick package, vendor, and make sure return a price');
			}
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

			reorderRow();
		}
	});

	/**
     * Remove row item of packaging
     */
	pricingWrapper.on('click', '.btn-remove-packaging', function (e) {
		e.preventDefault();

		$(this).closest('.additional-package').remove();

		calculatePrice();
		reorderRow();
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
			reorderRow();
		}
	});

	/**
     * Remove row item of surcharge
     */
	pricingWrapper.on('click', '.btn-remove-surcharge', function (e) {
		e.preventDefault();

		$(this).closest('.additional-surcharge').remove();

		calculatePrice();
		reorderRow();
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
				tax = 0.02 * totalSellBeforeTax;
			}
			const totalSellAfterTax = totalSellBeforeTax + tax;

			$(pricingItem).find('.label-purchase-amount').text(formatter.setNumberValue(totalPurchase, 'Rp. '));
			$(pricingItem).find('.label-sell-before-tax').text('(' + formatter.setNumberValue(margin) + '%) ' + formatter.setNumberValue(totalSellBeforeTax, 'Rp. '));
			$(pricingItem).find('.label-sell-after-tax').text(formatter.setNumberValue(totalSellAfterTax, 'Rp. '));

		});
	}

	function reorderRow() {
		pricingWrapper.find('.pricing-item').each(function (index) {
			// reorder index of inputs pricing
			$(this).find('input[name],select[name]').each(function () {
				const pattern = new RegExp("pricing[([0-9]*\\)?]", "i");
				const attributeName = $(this).attr('name').replace(pattern, 'pricing[' + index + ']');
				$(this).attr('name', attributeName);
			});

			$(this).find('.row-packaging').each(function (indexPackaging) {
				$(this).find('input[name],select[name]').each(function () {
					const pattern = new RegExp("\\[packaging\\][([0-9]*\\)?]", "i");
					const attributeName = $(this).attr('name').replace(pattern, '[packaging][' + indexPackaging + ']');
					$(this).attr('name', attributeName);
				});
			});

			$(this).find('.row-surcharge').each(function (indexSurcharge) {
				$(this).find('input[name]').each(function () {
					const pattern = new RegExp("\\[surcharges\\][([0-9]*\\)?]", "i");
					const attributeName = $(this).attr('name').replace(pattern, '[surcharges][' + indexSurcharge + ']');
					$(this).attr('name', attributeName);
				});
			});
		});
	}

};
