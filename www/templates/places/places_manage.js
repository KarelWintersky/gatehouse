$(document).ready(function () {
    $(".action-backward").on('click', function () {
        window.location.href = $(this).data('url');
        return false;
    });

    $(".checkbox_owner_status").on('change', function () {

    });

    $("#actor-add-phone").on('click', function () {
        var $input_add_phone = $('#input-add-phone');
        /*
        var data = {
            id: Math.floor(Math.random() * (100 - 1 + 1)) + 1,
            phone_number: $input_add_phone.val()
        };

        $('#container-phones').append(`
            <li data-id="${data.id}">
                <input type="text" width="40" data-id="${data.id}" value="${data.phone_number}">
                <button class="action-delete-phone" data-id="${data.id}">DELETE</button>
            </li>
            `);
        */

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
                        <input type="text" width="40" data-id="${data.id}" value="${data.phone_number}" disabled>
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

    $(document).on('click', '.action-delete-phone', function () {
        var phone_id = $(this).data('id');
        $(`#container-phones li[data-id="${phone_id}"]`).remove();
    });

});