<?php
  class Seed {
    public static function import() {
      $post_has_the_term = get_site_option("post_has_the_term", null);
      if (is_null($post_has_the_term)) {
        add_site_option("post_has_the_term", 1);
      }
    }
  }
?>
