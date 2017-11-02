function spip_zoundation() {
    $(".reveal").on("closed.zf.reveal", function() {
        ajaxReload("content");
    });
}

spip_zoundation();
onAjaxLoad(function() {
    spip_zoundation();
});
