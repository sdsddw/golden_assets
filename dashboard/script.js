// SIDEBAR DROPDOWN
$('#sidebar .side-dropdown').each(function () {
    const a = $(this).parent().find('a:first-child');
    a.on('click', function (e) {
        e.preventDefault();

        if (!$(this).hasClass('active')) {
            $('#sidebar .side-dropdown').each(function () {
                const aLink = $(this).parent().find('a:first-child');
                aLink.removeClass('active');
                $(this).removeClass('show');
            });
        }

        $(this).toggleClass('active');
        $(this).next('.side-dropdown').toggleClass('show');
    });
});

// SIDEBAR COLLAPSE
const toggleSidebar = $('nav .toggle-sidebar');
const allSideDivider = $('#sidebar .divider');

toggleSidebar.on('click', function () {
    $('#sidebar').toggleClass('hide');
    allSideDivider.text(function () {
        return $('#sidebar').hasClass('hide') ? '-' : $(this).data('text');
    });

    if ($('#sidebar').hasClass('hide')) {
        $('#sidebar .side-dropdown').removeClass('show');
        $('#sidebar .side-dropdown').parent().find('a:first-child').removeClass('active');
    }
});

$('#sidebar').on('mouseleave', function () {
    if ($(this).hasClass('hide')) {
        $('#sidebar .side-dropdown').removeClass('show');
        $('#sidebar .side-dropdown').parent().find('a:first-child').removeClass('active');
        allSideDivider.text('-');
    }
});

$('#sidebar').on('mouseenter', function () {
    if ($(this).hasClass('hide')) {
        $('#sidebar .side-dropdown').removeClass('show');
        $('#sidebar .side-dropdown').parent().find('a:first-child').removeClass('active');
        allSideDivider.text(function () {
            return $(this).data('text');
        });
    }
});

// PROFILE DROPDOWN
$('nav .profile img').on('click', function () {
    $(this).siblings('.profile-link').toggleClass('show');
});

// MENU
$('main .content-data .head .menu .icon').on('click', function () {
    $(this).parent().find('.menu-link').toggleClass('show');
});

$(window).on('click', function (e) {
    const imgProfile = $('nav .profile img');
    const dropdownProfile = $('nav .profile .profile-link');

    if (!$(e.target).is(imgProfile) && !$(e.target).is(dropdownProfile)) {
        dropdownProfile.removeClass('show');
    }

    $('main .content-data .head .menu').each(function () {
        const icon = $(this).find('.icon');
        const menuLink = $(this).find('.menu-link');

        if (!$(e.target).is(icon) && !$(e.target).is(menuLink)) {
            menuLink.removeClass('show');
        }
    });
});

// PROGRESSBAR
$('main .card .progress').each(function () {
    $(this).css('--value', $(this).data('value'));
});
