// START REORDER LIST ITEMS FOR ORDER BY
/*$(function () {
    $('.droptrue').on('click', 'li', function () {
        $(this).toggleClass('selected');
    });

    $("ol.droptrue").sortable({
        connectWith: 'ol.droptrue',
        opacity: 0.6,
        revert: true,
        helper: function (e, item) {
            if (!item.hasClass('selected'))
                item.addClass('selected');
            var elements = $('.selected').not('.oi-sortable-placeholder').clone();
            var helper = $('<ol/>');
            item.siblings('.selected').addClass('hidden');
            return helper.append(elements);
        },
        start: function (e, ui) {
            var elements = ui.item.siblings('.selected.hidden').not('.oi-sortable-placeholder');
            ui.item.data('items', elements);
        },
        receive: function (e, ui) {
            ui.item.before(ui.item.data('items'));
        },
        stop: function (e, ui) {
            ui.item.siblings('.selected').removeClass('hidden');
            $('.selected').removeClass('selected');
        },
        update: updatePostOrder
    });

    $("#orderBy").disableSelection();
    $("#orderBy").css('minHeight', $("#orderBy").height() + "px");
    updatePostOrder();
});

function updatePostOrder() {
    console.log("works");
}*/
// END REORDER LIST ITEMS FOR ORDER BY