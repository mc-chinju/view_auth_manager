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

  use Illuminate\Database\Capsule\Manager as Capsule;

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

    register_setting(
      "view_auth_settings",
      "post_has_the_term"
    );
  }

  function display_plugin_admin_page() {
    include_once( "views/menu_page.php" );
    wp_enqueue_style( "menu_page", plugins_url( "style/menu_page.css", __FILE__ ) );
  }

  function before_action_show_post() {
    if (is_singular()) {
      $capsule = new Capsule;

      $current_user = wp_get_current_user();
      $post_id = get_the_ID();

      $view_auth_level_postmeta = $capsule::table("postmeta")->where("post_id", $post_id)->where("meta_key", "view_auth_level")->first();
      $view_auth_level = $view_auth_level_postmeta ? $view_auth_level_postmeta->meta_value : 0;

      $view_auth_term_id_postmeta = $capsule::table("postmeta")->where("post_id", $post_id)->where("meta_key", "view_auth_term_id")->first();
      $view_auth_term_id = $view_auth_term_id_postmeta ? $view_auth_term_id_postmeta->meta_value : null;

      $phtm_value = get_site_option("post_has_the_term") || 0;
      if ($phtm_value) {
        $term_ids = $capsule::table("term_relationships")->where("object_id", $post_id)->pluck("term_taxonomy_id")->all();
        $key = array_search($view_auth_term_id, $term_ids);
        $view_auth_term_id = $key ? $term_ids[$key] : null;
      }

      $progress = $capsule::table("vam_progresses")->where("user_id", $current_user->ID)->where("term_id", $view_auth_term_id)->first();
      $progress_level = $progress->level ?: 0;

      // readable check
      if ((is_null($view_auth_term_id)) || ($progress_level >= $view_auth_level)) {
        // Noop
      } else {
        // TODO: Access accessable term_id's latest post
        wp_safe_redirect(home_url(), 301);
        exit;
      }
    }
  }

  function prepare_ajaxurl() {
    ?>
      <script>
        const ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>"";
      </script>
    <?php
  }

  register_activation_hook( __FILE__, "migrate" );
  register_activation_hook( __FILE__, "seed" );
  register_deactivation_hook( __FILE__, "drop" );
  add_action( "admin_menu", "add_plugin_admin_menu" );
  add_action( "template_redirect", "before_action_show_post" );
  add_action( "wp_head", "prepare_ajaxurl", 1 );
?>
