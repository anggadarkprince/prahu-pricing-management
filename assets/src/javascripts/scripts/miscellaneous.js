$(function () {
    // initialize date picker
    $('.datepicker:not([readonly])').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        drops: $('#modal-filter').length ? 'up' : 'down',
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY'
        },
        parentEl: $("#modal-filter").length ? ".modal-body" : 'body'
    }).on("apply.daterangepicker", function (e, picker) {
        picker.element.val(picker.startDate.format(picker.locale.format));
    }).on("hide.daterangepicker", function (e, picker) {
        setTimeout(function () {
            if (picker.element.val()) {
                $(picker.element).closest('.form-group').find('.formatted-date').text(picker.startDate.format('DD MMMM YYYY'));
            } else {
                $(picker.element).closest('.form-group').find('.formatted-date').text('(Pick a date)');
            }
        }, 150);
    });

    $('form .datepicker').keydown(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });

    // Select2
    const selects = $('.select2');
    selects.each(function (index, select) {
        $(select).select2({
            minimumResultsForSearch: 10,
            placeholder: 'Select data'
        }).on("select2:open", function () {
            $(".select2-search__field").attr("placeholder", "Search...");
        }).on("select2:close", function () {
            $(".select2-search__field").attr("placeholder", null);
        });
    });

    // Tooltip
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    // Popover
    $('[data-toggle="popover"]').popover();

    // Clickable
    $('[data-clickable=true]').on('click', function () {
        window.location.href = $(this).data('url');
    });
});
