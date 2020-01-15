// import global variable
import variables from "./components/variables";

// jquery and bootstrap is main library of this app.
try {
    // get jquery ready in global scope
    window.$ = window.jQuery = require('jquery');
    $.ajaxSetup({
        headers: {
            "X-CSRFToken": variables.csrfToken
        }
    });

    // loading library core
    require('bootstrap');
    require('jquery-validation');
    window.moment = require('moment');
    require('daterangepicker');
    require('select2');
	//require('datatables.net');
	require('datatables.net-bs4');

    // loading misc scripts
    require('./scripts/validation');
    require('./scripts/custom-upload-button');
    require('./scripts/table-responsive');
    require('./scripts/currency-value');
    require('./scripts/one-touch-submit');
    require('./scripts/miscellaneous');

    // load async page scripts
    if ($('.btn-delete').length && $('#modal-delete').length) {
        import("./components/delete").then(modalDelete => modalDelete.default());
    }

    if ($('.btn-validate').length && $('#modal-validate').length) {
        import("./components/validate").then(modalValidate => modalValidate.default());
    }

    if ($('#form-role').length) {
        import("./pages/role").then(role => role.default());
    }

    if ($('#form-package').length) {
        import("./pages/package").then(packages => packages.default());
    }

    if ($('#form-consumable').length) {
        import("./pages/consumable").then(consumable => consumable.default());
    }

    if ($('#form-component-price').length) {
        import("./pages/component-price").then(componentPrice => componentPrice.default());
    }

    if ($('#form-calculator').length) {
        import("./pages/calculator-price").then(calculatorPrice => calculatorPrice.default());
    }

} catch (e) {
    console.log(e);
}

// include sass (but extracted by webpack into separated css file)
import '../sass/plugins.scss';
import '../sass/app.scss';
