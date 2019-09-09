$(document).ready(function () {
    $(".action-goto-url").on('click', function () {
        window.location.href = $(this).data('url');
        return false;
    });

    $(".action-list-edit").on('click', function () {
        window.location.href = urls.edit + $(this).data('id');
        return false;
    });
});