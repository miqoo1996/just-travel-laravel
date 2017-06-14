$(function() {
    var stop = function(event, ui) {
        var $ul = ui.item.closest('ul'),
            ajax_url = ui.item.closest('ul').data('ajax'),
            items = [];

        $ul.find('li').each(function () {
            items.push({
                page_id: $(this).data('page-id'),
                order: $(this).index()
            });
        });

        if (items !== {}) {
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: {
                    items: items
                },
                success: function() {
                    console.log('success');
                }
            });
        }
    };

    $( "#sortable-right-menu-pages, #sortable-footer-pages" ).sortable({
        stop: stop
    });
});