$(document).ready(function () {
    /**
     * Static Actors
     */

    /**
     * Dynamic Actors
     */
    $(".action-goto-url").on('click', function () {
        window.location.href = $(this).data('url');
        return false;
    });

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
});