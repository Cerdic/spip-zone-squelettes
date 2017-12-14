function spip_zoundation() {
    $(".reveal").on("closed.zf.reveal", function() {
        ajaxReload("content");
    });
}

$(function() {
    spip_zoundation();
    onAjaxLoad(function() {
        spip_zoundation();
    });
});
