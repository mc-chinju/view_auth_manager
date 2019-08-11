jQuery(function($) {
  $("[id^=vam_form_]").submit(function(e) {
    e.preventDefault();
    const fd = new FormData(this);

    fd.append("action", "update_post_metadata");
    fd.append("nonce", vam_ajax.nonce);

    // for (let value of fd.entries()) {
    //   console.log(value);
    // }

    $.ajax({
      url: vam_ajax.ajax_url,
      type: "POST",
      data: fd,
      contentType: false,
      processData: false,
      success: function(message) {
        toastr.success(message);
      },
      error: function(e) {
        toastr.error(`Error: ${e}`);
      }
    });
    return false;
  });
});
