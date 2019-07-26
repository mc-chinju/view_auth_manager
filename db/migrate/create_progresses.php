<?php
  class CreateProgresses {

    public function change() {
      global $wpdb;
      global $vam_db_version;
      $table_name = $wpdb -> prefix . "vam_progresses";
      $charset_collate = $wpdb -> get_charset_collate();

      $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        level int DEFAULT 0 NOT NULL,
        user_id bigint NOT NULL,
        term_taxonomy_id bigint NOT NULL,
        UNIQUE KEY id (id)
      ) $charset_collate;";

      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
      dbDelta( $sql );
      add_option("vam_db_version", $vam_db_version);
    }
  }
 ?>