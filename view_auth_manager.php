<?php
  /*
    Plugin Name: View Auth Manager
    Plugin URI:
    Description: This plugin manages viewing authority to the post.
    Version: 0.1.0
    Author: mc-chinju
    Author URI: https://github.com/mc-chinju/view_auth_manager
    License: Apache Lisence 2.0
  */

  global $vam_db_version;
  $vam_db_version = "0.1.0";

  require_once dirname(__FILE__) . '/db/migrate/create_progresses.php';

  function migrate() {
    $create_progresses = new CreateProgresses;
    $create_progresses -> change();
  }

  function drop() {
    global $wpdb;
    $table_name = $wpdb -> prefix . "vam_progresses";
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb -> query($sql);
    delete_option($vam_db_version);
  }

  register_activation_hook( __FILE__, "migrate" );
  register_deactivation_hook( __FILE__, "drop" );
?>
