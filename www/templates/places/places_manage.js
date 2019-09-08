$(document).ready(function () {
    // обработчик эктора "назад"
    $(".action-backward").on('click', function () {
        window.location.href = $(this).data('url');
        return false;
    });

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
        }).done(function (data) {
            if (data.success == 1) {
                $input_add_phone.val('');

                $('#container-phones').append(`
                    <li data-id="${data.id}">
                        <input type="text" size="18" data-id="${data.id}" value="${data.phone_number}" disabled>
                        <button class="action-delete-phone" data-id="${data.id}">DELETE</button>
                    </li>
                `);
            } else {
                if (data['error'] == 1062) {
                    // это дубль
                    console.log('Duplicate phone');
                    alert('Номер не добавлен. Он уже зарегистрирован на этом участке');
                } else {
                    console.log( data.error );
                    // это неизвестно что
                }
            }
        });
    });

    // обработчик эктора "удалить номер телефона"
    $(document).on('click', '.action-delete-phone', function () {
        var phone_id = $(this).data('id');
        $.ajax({
            url: '/ajax/delete_phone',
            data: {
                phone_id: phone_id
            },
            dataType: 'json'
        }).done(function (data) {
            if (data.success == 1) {
                $(`#container-phones li[data-id="${phone_id}"]`).remove();
            } else {
                alert(data.error);
            }
        });
    });

    // ==========================================================



});