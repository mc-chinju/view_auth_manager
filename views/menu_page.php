<div class="wrap">
  <h2>View Auth Manager</h2>
  <h3>Settings</h3>
  <form method="post" action="options.php">
    <?php
      settings_fields("view_auth_settings");
      do_settings_sections( "default" );
      $phtm_value = get_site_option("post_has_the_term");
      $phtm_checked = empty($phtm_value) ? "" : "checked='checked'";
    ?>
    <table class="form-table">
      <tbody>
        <tr>
          <th scope="row"><label for="post_has_the_term">Post has the term</label></th>
          <td>
            <input type="hidden" name="post_has_the_term" value="0">
            <label for="post_has_the_term">
              <input type="checkbox" id="post_has_the_term" name="post_has_the_term" size="30" value="1"<?php echo $phtm_checked; ?>/>
                ※ Restrict access only when an article is associated with the tag or taxonomy.
              </input>
            </label>
            <div></div>
          </td>
        </tr>
      </tbody>
    </table>
    <?php submit_button();?>
  </form>

  <h3>Posts meta data</h3>
  <table class="wp-list-table widefat fixed striped posts">
    <thead>
      <tr>
        <td>Title</td>
        <td>Post Status</td>
        <td>View Auth Tag or Taxonomy</td>
        <td>View Auth Level</td>
        <td>Edit</td>
      </tr>
    </thead>
    <tbody>

    <?php
      use Illuminate\Database\Capsule\Manager as Capsule;
      $capsule = new Capsule;
      $terms = $capsule::table("terms")->pluck("name", "term_id");

      // TODO: pagination
      $args = array("posts_per_page" => -1);
      $myposts = new WP_Query($args);

      if ($myposts -> have_posts()) {
        foreach($myposts -> posts as $post){
          $title = $post -> post_title;
          $status = $post -> post_status;
          $view_auth_level = ($post -> view_auth_level) ?: 0;
          $view_auth_term_id = ($post -> view_auth_term_id);
          $term = $terms[$view_auth_term_id];

          echo("<tr>
            <td> $title </td>
            <td> $status </td>
            <td> $term </td>
            <td> $view_auth_level </td>
            <td><a>Edit</a></td>
          </tr>");
        }
      }
    ?>
    </tbody>
  </table>
</div>
