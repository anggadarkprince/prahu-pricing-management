import variables from "../components/variables";

export default function () {

    /**
     * url: /master/package/{create/({edit/:id})}
     * Fetch sub component that live in component type.
     */
    const formComponentPrice = $('#form-component-price');
    const selectComponent = formComponentPrice.find('#component');
    const selectSubComponent = formComponentPrice.find('#sub_component');

    selectComponent.on('change', function() {
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