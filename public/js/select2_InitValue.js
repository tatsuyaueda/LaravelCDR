//

function select2_Init(select2Obj, Uri, param) {

    return select2Obj
            .select2({
                ajax: {
                    url: Uri,
                    dataType: 'json',
                    data: function (term, page) {
                        return {
                            type: $('select[name=type]').val(),
                            from: 'GroupEdit'
                        };
                    },
                    processResults: function (data, params) {
                        return {
                            results: data,
                        };
                    },
                    cache: true,
                },
                minimumResultsForSearch: Infinity,
                templateResult: function (node) {
                    return $('<span style="padding-left:' + (10 * node.level) + 'px;">' + node.text + '</span>');
                }
            });

}

/**
 * 
 * @returns {undefined}
 */
function select2_InitValue(select2Obj, Uri, param, initValue) {

    var $option = $('<option selected>読み込み中...</option>').val(initValue);
    select2Obj.append($option).trigger('change');

    $.ajax({
        type: 'GET',
        url: Uri,
        dataType: 'json',
        data: param,
        success: function (data) {
            var filtered = $.grep(data,
                    function (elem, index) {
                        return (elem.id == initValue);
                    }
            );

            $option.text(filtered[0].text).val(filtered[0].id);
            $option.removeData();
            select2Obj.trigger('change');
        }
    });
}