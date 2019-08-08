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

  require_once(dirname(__FILE__) . "/db/migrate/create_progresses.php");
  require_once(dirname(__FILE__) . "/db/drop_dbs.php");
  require_once(dirname(__FILE__) . "/db/seeds.php");
  require_once(dirname(__FILE__) . "/config/database.php");

  function migrate() {
    CreateProgresses::change();
  }

  function seed() {
    Seed::import();
  }

  function drop() {
    DropDbs::execute();
  }

  function add_plugin_admin_menu() {
    add_options_page(
      "View Auth Manager",
      "View Auth Manager",
      "administrator",
      "view-auth-manager",
      "display_plugin_admin_page"
    );
  }

  function display_plugin_admin_page() {
    include_once( "views/menu_page.php" );
    wp_enqueue_style( "menu_page", plugins_url( "style/menu_page.css", __FILE__ ) );
  }

  register_activation_hook( __FILE__, "migrate" );
  register_activation_hook( __FILE__, "seed" );
  register_deactivation_hook( __FILE__, "drop" );
  add_action( "admin_menu", "add_plugin_admin_menu" );
?>
