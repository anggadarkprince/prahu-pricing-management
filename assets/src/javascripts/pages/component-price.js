import variables from "../components/variables";

export default function () {

    /**
     * url: /master/package/{create/({edit/:id})}
     * Fetch sub component that live in component type.
     */
    const formComponentPrice = $('#form-component-price');
    const selectComponent = formComponentPrice.find('#component');
    const selectVendor = formComponentPrice.find('#vendor');
    const labelVendor = formComponentPrice.find('label[for="vendor"]');
    const locationOrigin = formComponentPrice.find('#location_origin');
    const locationDestination = formComponentPrice.find('#location_destination');
    const portOrigin = formComponentPrice.find('#port_origin');
    const portDestination = formComponentPrice.find('#port_destination');
    const tableSubComponent = formComponentPrice.find('#table-sub-component-price');

    function setupCombination() {
        selectVendor.find('option').prop('disabled', false);

        const provider = selectComponent.find('option:selected').data('provider');
        const serviceLocation = selectComponent.find('option:selected').data('service-section');

        if (provider === 'TRUCKING') {
            labelVendor.text('Trucking');
            selectVendor.find('option[data-type="SHIPPING LINE"]').prop('disabled', true);
        } else {
            labelVendor.text('Shipping Line');
            selectVendor.find('option[data-type="TRUCKING"]').prop('disabled', true);
        }

        if (serviceLocation === 'ORIGIN') {
            locationDestination.val('').trigger('change').prop('disabled', true);
            portDestination.val('').trigger('change').prop('disabled', true);
            if (provider === 'SHIPPING LINE') {
                locationOrigin.val('').trigger('change').prop('disabled', true);
            } else {
                locationOrigin.prop('disabled', false);
            }
        } else if (serviceLocation === 'DESTINATION') {
            locationOrigin.val('').trigger('change').prop('disabled', true);
            portOrigin.val('').trigger('change').prop('disabled', true);
            if (provider === 'SHIPPING LINE') {
                locationDestination.val('').trigger('change').prop('disabled', true);
            } else {
                locationDestination.prop('disabled', false);
            }
        } else if (serviceLocation === 'SHIPPING') {
            if (provider === 'SHIPPING LINE') {
                locationOrigin.val('').trigger('change').prop('disabled', true);
                locationDestination.val('').trigger('change').prop('disabled', true);
                portOrigin.prop('disabled', false);
                portDestination.prop('disabled', false);
            } else {
                portOrigin.val('').trigger('change').prop('disabled', true);
                portDestination.val('').trigger('change').prop('disabled', true);
                locationOrigin.prop('disabled', false);
                locationDestination.prop('disabled', false);
            }
        }

        selectVendor.select2({
            minimumResultsForSearch: 10,
            placeholder: 'Select data'
        }).on("select2:open", function () {
            $(".select2-search__field").attr("placeholder", "Search...");
        }).on("select2:close", function () {
            $(".select2-search__field").attr("placeholder", null);
        });
    }

    selectComponent.on('change', function() {
        setupCombination();
        
        const query = $.param({
            id_component: $(this).val(),
        });
        fetch(variables.baseUrl + 'master/sub-component/ajax-get-by-component?' + query)
            .then(result => result.json())
            .then(data => {
                tableSubComponent.find('tbody').empty();
                if (data && data.length > 0) {
                    data.forEach((row, index) => {
                        tableSubComponent.find('tbody').append(
                            `<tr>
                                <td>${index+1}</td>
                                <td>${row.sub_component}</td>
                                <td>
                                    <input type="hidden" name="prices[${index}][id_sub_component]" value="${row.id}" required>
                                    <input type="hidden" name="prices[${index}][sub_component]" value="${row.sub_component}" required>
                                    <input type="text" class="form-control currency" name="prices[${index}][price]" placeholder="${row.sub_component} price" required>
                                </td>
                            </tr>`
                        );
                    });
                }
            })
            .catch(console.log);
    });

    setupCombination();
};