import variables from "../components/variables";

export default function () {

    /**
     * url: /pricing/calculator/{create/({edit/:id})}
     * Manage form calculator of pricing.
     */
    const formCalculator = $('#form-calculator');
    const selectInsurance = formCalculator.find('#insurance');
    const inputGoodsValue = formCalculator.find('#goods_value');

    selectInsurance.on('change', function () {
        if ($(this).val() === '1') {
            inputGoodsValue.prop('readonly', false);
        } else {
            inputGoodsValue.val('').prop('readonly', true);
        }
    });

    const selectService = formCalculator.find('#service');
    selectService.on('change', function() {
        const query = $.param({
            id_service: $(this).val(),
        });
        fetch(variables.baseUrl + 'master/service/ajax-get-service?' + query)
            .then(result => result.json())
            .then(data => {
                console.log(data);
            })
            .catch(console.log);
    });
};