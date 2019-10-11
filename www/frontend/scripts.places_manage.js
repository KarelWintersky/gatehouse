$(document).ready(function () {
    // обработчик эктора "изменить доступ к участку"
    $(".checkbox_owner_status").on('change', function () {

    });

    // обработчик эктора "Добавить номер телефона"
    $("#actor-add-phone").on('click', function () {
        var $input_add_phone = $('#input-add-phone');

        if ($input_add_phone.val().trim() == '') {
            $input_add_phone.val('');
            return;
        }

        $.ajax({
            url: '/ajax/add_phone',
            data: {
                id_allotment:   $("#allotment_hidden_id").val(),
                phone_number:   $input_add_phone.val()
            },
            dataType: 'json'
        }).done(function (response) {
            if (response.error == 0) {
                $input_add_phone.val('');

                $('#container-phones').append(`
                    <li data-id="${response.id_phone}">
                        <input type="text" size="18" data-id="${response.id_phone}" value="${response.phone_number}" disabled>
                        <button class="action-delete-phone" data-id="${response.id_phone}">DELETE</button>
                    </li>
                `);
            } else {
                if (response.error == 1062) {
                    // это дубль
                    console.log('Duplicate phone');
                    alert('Этот номер телефона уже где-то зарегистрирован (возможно здесь!)');
                } else {
                    console.log( response.errorMsg );
                    alert('Неизвестная ошибка: ' + response.errorMsg);
                }
            }
        });
    });

    // обработчик эктора "удалить номер телефона"
    $(document).on('click', '.action-delete-phone', function () {
        var phone_id = $(this).data('id');

        if (!confirm('Действительно удалить телефонный номер?')) {
            return false;
        }

        $.ajax({
            url: '/ajax/delete_phone',
            data: {
                phone_id: phone_id
            },
            dataType: 'json'
        }).done(function (data) {
            if (data.error == 0) {
                $(`#container-phones li[data-id="${phone_id}"]`).remove();
            } else {
                alert(data.errorMsg);
            }
        });
    });

    // ==========================================================

    // обработчик эктора "Добавить номер автомашины"
    $("#actor-add-transport").on('click', function () {
        var $input_add_transport = $('#input-add-transport');

        if ($input_add_transport.val().trim() == '') {
            $input_add_transport.val('');
            return;
        }

        $.ajax({
            url: '/ajax/add_transport',
            data: {
                id_allotment:       $("#allotment_hidden_id").val(),
                transport_number:   $input_add_transport.val()
            },
            dataType: 'json'
        }).done(function (data) {
            if (data.error == 0) {
                $input_add_transport.val('');

                $('#container-transport').append(`
                    <li data-id="${data.id}">
                        <input type="text" size="18" data-id="${data.id}" value="${data.transport_number}" disabled>
                        <button class="action-delete-transport button-height-30" data-id="${data.id}">DELETE</button>
                    </li>
                `);
            } else {
                console.log(data.errorMsg);

                if (data['error'] == 1062) {
                    // это дубль
                    alert('Этот автомобиль уже где-то зарегистрирован (возможно здесь!)');
                } else {
                    // это неизвестно что
                }
            }
        });
    });

    // обработчик эктора "удалить номер телефона"
    $(document).on('click', '.action-delete-transport', function () {
        var transport_id = $(this).data('id');

        if (!confirm('Действительно удалить транспортное средство?')) {
            return false;
        }

        $.ajax({
            url: '/ajax/delete_transport',
            data: {
                transport_id: transport_id
            },
            dataType: 'json'
        }).done(function (data) {
            if (data.error == 0) {
                $(`#container-transport li[data-id="${transport_id}"]`).remove();
            } else {
                alert(data.errorMsg);
            }
        });
    });

    // input mask на номер транспортного средства (0-9, латиница)
    // не используется, потому что в инпут могут копипастить номер с русскими буквами,
    // которые плагином не допускаются
    // требует <script type="text/javascript" src="/frontend/jquery/jquery.inputmask.min.js"></script>
    // в www/templates/places/form_manage.html
    /*$("#input-add-transport").inputmask({
        regex: "[0-9A-Z\-]*",
        placeholder: "Номер транспортного средства"
    });*/

});