import variables from "../components/variables";
import showAlert from "../components/alert";

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
				pricingWrapper.find('.label-component-price').text('');
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
						componentRow.find('.label-component-price').text('Rp. 0');
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
};
