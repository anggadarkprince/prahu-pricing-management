import variables from "../components/variables";

export default function () {

    /**
     * url: /master/package/{create/({edit/:id})}
     * Fetch sub component that live in component type.
     */
    const formPackage = $('#form-package');
    const selectComponent = formPackage.find('#component');
    const subComponentWrapper = formPackage.find('#sub-component-wrapper');

    selectComponent.on('change', function() {
        subComponentWrapper.text('Fetching...');
        const query = $.param({
            id_component: $(this).val(),
        });
        fetch(variables.baseUrl + 'master/sub-component/ajax-get-by-component?' + query)
            .then(result => result.json())
            .then(data => {
                subComponentWrapper.empty();
                if (data && data.length > 0) {
                    data.forEach(row => {
                        subComponentWrapper.append(`
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input"
                                    id="sub_component_${row.id}" name="sub_components[${row.id}]" value="${row.id}">
                                <label class="custom-control-label" for="sub_component_${row.id}">
                                    ${row.sub_component}
                                </label>
                            </div>
                        `);
                    });
                } else {
                    subComponentWrapper.text('<span class="text-danger">No sub component data available</span>');
                }
            })
            .catch(console.log);
    });

};