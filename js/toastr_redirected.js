jQuery(document).ready(function() {
  urlParams = new URLSearchParams(window.location.search);

  if (urlParams.get("vam_redirect")) {
    toastr.warning("You are not allowed to acces this page");
  }
});
