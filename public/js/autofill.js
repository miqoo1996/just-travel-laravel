$(function () {
    var options = {
        url: "/resources/tags/9996487a1df5",
        getValue: "name",
        list: {
            match: {
                enabled: true
            },
            maxNumberOfElements: 8
        },
        template: {
            type: "custom",
            method: function(value, item) {
                return "<span class='search-item-" + (item.code) + "' >" + value +"</span>";
            }
        }
    };
    $("#tags").easyAutocomplete(options);
});