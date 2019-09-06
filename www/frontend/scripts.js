$(document).ready(function () {
    $(".action-list-add").on('click', function () {
        window.location.href = urls.add;
    });

    $(".action-list-edit").on('click', function () {
        window.location.href = urls.edit + $(this).data('id');
    });

    $(".action-list-back").on('click', function () {
        window.location.href = $(this).data('url');
    });
});