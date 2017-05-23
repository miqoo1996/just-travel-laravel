$(function () {
    var options = {
        url: "/resources/tags",
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