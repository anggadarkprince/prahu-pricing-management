$(function () {
    // mobile sidebar
    $('[data-toggle="offcanvas"]').on("click", function () {
        $('.sidebar-offcanvas').toggleClass('active')
    });

    const body = $('body');
    // On click, capture state and save it in localStorage
    if ($(window).width() > 992) {
        if (localStorage.getItem('finance-sidebar-closed') === '1') {
            body.addClass("sidebar-icon-only");
        }
    }

    // Open submenu on hover in compact sidebar mode and horizontal menu mode
    $(document).on('mouseenter mouseleave', '.sidebar .nav-item', function (ev) {
        const sidebarIconOnly = body.hasClass("sidebar-icon-only");
        const sidebarFixed = body.hasClass("sidebar-fixed");
        if (!('ontouchstart' in document.documentElement)) {
            if (sidebarIconOnly) {
                if (sidebarFixed) {
                    if (ev.type === 'mouseenter') {
                        body.removeClass('sidebar-icon-only');
                    }
                } else {
                    const $menuItem = $(this);
                    if (ev.type === 'mouseenter') {
                        $menuItem.addClass('hover-open')
                    } else {
                        $menuItem.removeClass('hover-open')
                    }
                }
            }
        }
    });

    const sidebar = $('.sidebar');
    sidebar.on('show.bs.collapse', '.collapse', function () {
        sidebar.find('.collapse.show').collapse('hide');
    });

    // change sidebar
    $('[data-toggle="minimize"]').on("click", function () {
        body.toggleClass('sidebar-icon-only');
        localStorage.setItem('finance-sidebar-closed', body.hasClass('sidebar-icon-only') ? 1 : 0);
    });

    // checkbox and radios
    $(".form-check label,.form-radio label").append('<i class="input-helper"></i>');

    // initialize date picker
    $('.datepicker:not([readonly])').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY'
        }
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
