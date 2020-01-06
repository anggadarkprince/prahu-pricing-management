import variables from "../components/variables";

export default function () {

	/**
	 * url: /master/consumable/{create/({edit/:id})}
	 * Change mode consumable form.
	 */
	const formConsumable = $('#form-consumable');
	const selectType = formConsumable.find('#type');
	const modeValue = formConsumable.find('.mode-value');
	const modePercent = formConsumable.find('.mode-percent');

	selectType.on('change', function () {
		if ($(this).val() === 'PACKAGING') {
			modePercent.hide();
			modePercent.find('input').val('');
			modePercent.find('select').val('').trigger('change');
			modeValue.show();
		} else {
			modePercent.show();
			modeValue.hide();
			modeValue.find('input').val('');
		}
	});

	if(formConsumable.hasClass('edit')) {
		selectType.trigger('change');
	}
};
