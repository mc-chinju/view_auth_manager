<?php
  class Seed {
    public function import() {
      global $wpdb;
      $table_name = $wpdb -> prefix . "vam_progresses";
    }
  }
?>
