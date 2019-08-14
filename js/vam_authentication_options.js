jQuery(function($) {
  $("[data-action='vam-progress-level']").on("click", function(e) {
    e.preventDefault();

    const settings = VamAuthenticationSettings;

    $.ajax({
      url: "/wp-json/vam/v1/current/progresses",
      method: "POST",
      data: { post_id: settings.post_id },
      beforeSend: function(xhr) {
        xhr.setRequestHeader("X-WP-Nonce", settings.nonce);
      }
    }).done(function(response) {
      console.log(response);
      // toastr.info(response["message"]);
    });
  });
});
