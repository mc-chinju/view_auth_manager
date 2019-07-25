<?php
  global $vam_db_version;
  $vam_db_version = "0.1.0";

  class CreateProgresses {
    public function change() {
      global $wpdb;
      global $vam_db_version;

      $table_name = $wpdb -> prefix . "vam_progresses";

      $charset_collate = $wpdb -> get_charset_collate();

      $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        name tinytext NOT NULL,
        text text NOT NULL,
        url varchar(55) DEFAULT '' NOT NULL,
        UNIQUE KEY id (id)
      ) $charset_collate;";

      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
      dbDelta( $sql );

      add_option( "vam_db_version", $vam_db_version );
    }
  }
 ?>