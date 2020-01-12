import variables from "../components/variables";
import showAlert from "../components/alert";
import formatter from "../components/formatter";

export default function () {

	/**
	 * url: /pricing/calculator/{create/({edit/:id})}
	 * Manage form calculator of pricing.
	 */
	const formCalculator = $('#form-calculator');
	const selectInsurance = formCalculator.find('#insurance');
	const inputGoodsValue = formCalculator.find('#goods_value');
	const pricingWrapper = formCalculator.find('#pricing-wrapper');

	selectInsurance.on('change', function () {
		if ($(this).val() === '1') {
			inputGoodsValue.prop('readonly', false);
		} else {
			inputGoodsValue.val('').prop('readonly', true);
		}
	});

	const selectService = formCalculator.find('#service');
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

	const selectLocationOrigin = formCalculator.find('#location_origin');
	const selectLocationDestination = formCalculator.find('#location_destination');
	const selectPortOrigin = formCalculator.find('#port_origin');
	const selectPortDestination = formCalculator.find('#port_destination');
	const selectContainerSize = formCalculator.find('#container_size');
	const selectContainerType = formCalculator.find('#container_type');

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
					if(data.length) {
						price = Number(data[0].price);
					}
					rowComponent.find('.input-component-price').val('Rp. ' + formatter.setNumberValue(price));
				})
				.catch(error => {
					rowComponent.find('.input-component-price').val('Rp. 0');
					showAlert('Error Fetching Data', 'Get price data failed, please try again!', error.message);
				});
		}
	});

};
