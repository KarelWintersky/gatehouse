$(document).ready(function () {
    var now = new Date();
    var eDay = (now.getDate() < 10) ? '0' + now.getDate() : now.getDate();
    var eMonth = (now.getMonth() < 10) ? '0' + (1 + now.getMonth()) : (1 + now.getMonth());

    $(".action-list-add").on('click', function () {
        window.location.href = urls.add;
        return false;
    });

    $(".action-list-edit").on('click', function () {
        window.location.href = urls.edit + $(this).data('id');
        return false;
    });

    $(".action-list-back").on('click', function () {
        window.location.href = $(this).data('url');
        return false;
    });

    $(".action-backward").on('click', function () {
        window.location.href = $(this).data('url');
        return false;
    });

    $(".form-manage-datepicker").datepicker({
        dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
        monthNames: ['Янв', 'Февр', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Авг', 'Сент', 'Окт', 'Ноябрь', 'Дек'],
        monthNamesShort: ['Янв', 'Февр', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Авг', 'Сент', 'Окт', 'Ноябрь', 'Дек'],
        firstDay: 1,
        dateFormat: 'yy-mm-dd',
        showOn: 'both',
        buttonText: "Выбрать дату",
        changeMonth: true,
        changeYear: true,
        defaultDate: now.getFullYear() + '-' + eMonth + '-' + eDay,
        minDate: "-20",
        maxDate: "+3Y"
    });
});