import variables from "../components/variables";

export default function () {

    /**
     * url: /master/package/{create/({edit/:id})}
     * Fetch sub component that live in component type.
     */
    const formComponentPrice = $('#form-component-price');
    const selectComponent = formComponentPrice.find('#component');
    const selectSubComponent = formComponentPrice.find('#sub_component');
    const selectVendor = formComponentPrice.find('#vendor');
    const labelVendor = formComponentPrice.find('label[for="vendor"]');
    const locationOrigin = formComponentPrice.find('#location_origin');
    const locationDestination = formComponentPrice.find('#location_destination');
    const portOrigin = formComponentPrice.find('#port_origin');
    const portDestination = formComponentPrice.find('#port_destination');

    selectComponent.on('change', function() {
        selectVendor.find('option').prop('disabled', false);

        //locationOrigin.val('').trigger('change').prop('disabled', true);
        //locationDestination.val('').trigger('change').prop('disabled', true);
        //portOrigin.val('').trigger('change').prop('disabled', true);
        //portDestination.val('').trigger('change').prop('disabled', true);

        const provider = $(this).find('option:selected').data('provider');
        const serviceLocation = $(this).find('option:selected').data('service-section');
        
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
        
        selectSubComponent.empty().append($('<option>', { value: '' }).text('Fetching...')).prop("disabled", true);
        const query = $.param({
            id_component: $(this).val(),
        });
        fetch(variables.baseUrl + 'master/sub-component/ajax-get-by-component?' + query)
            .then(result => result.json())
            .then(data => {
                selectSubComponent.empty().append($('<option>', { value: '' }).text('Select sub component')).prop("disabled", false);
                if (data && data.length > 0) {
                    data.forEach(row => {
                        selectSubComponent.append(
                            $('<option>', {
                                value: row.id,
                            }).text(row.sub_component)
                        );
                    });
                }
            })
            .catch(console.log);
    });

};