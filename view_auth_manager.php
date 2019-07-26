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

  register_activation_hook( __FILE__, "migrate" );
  register_activation_hook( __FILE__, "seed" );
  register_deactivation_hook( __FILE__, "drop" );
?>
