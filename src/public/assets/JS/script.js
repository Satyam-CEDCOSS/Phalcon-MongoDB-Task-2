$("#addMeta").click(function () {
    var clone = $("#meta .meta-row").last().clone(true);
    clone.val("");
    clone.appendTo($("#meta-rows"));
});

$("#removeMeta").click(function () {
    $(this).parent().remove();
});

$("#addVariation").click(function () {
    var clone = $("#variation .variation-row").last().clone(true);
    clone.val("");
    clone.appendTo($("#variation-rows"));
});

$("#removeVariation").click(function () {
    $(this).parent().remove();
});

$("#product").change(function () {
    let value = $("#product").val()
    $.ajax({
        type: "POST",
        url: "order/select",
        data: "val=" + value,
        datatype:'text',
        success: function(result) {
            location.reload();
        }
    });
});