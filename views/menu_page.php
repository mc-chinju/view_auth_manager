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
        <td></td>
      </tr>
    </thead>
    <tbody>

    <?php
      use Illuminate\Database\Capsule\Manager as Capsule;
      $capsule = new Capsule;

      $terms = $capsule::table("terms")->pluck("name", "term_id")->all();
      $category_term_ids = $capsule::table("term_taxonomy")->where("taxonomy", "category")->pluck("term_id")->all();
      $tag_term_ids = $capsule::table("term_taxonomy")->where("taxonomy", "post_tag")->pluck("term_id")->all();
      $category_terms = array();
      $tag_terms = array();
      $other_terms = array();
      foreach($terms as $_term_id => $_name) {
        if (in_array($_term_id, $category_term_ids)) {
          $category_terms += array($_term_id => $_name);
        } elseif(in_array($_term_id, $tag_term_ids)) {
          $tag_terms += array($_term_id => $_name);
        } else {
          $other_terms += array($_term_id => $_name);
        }
      };

      // TODO: pagination
      $args = array("posts_per_page" => -1);
      $myposts = new WP_Query($args);

      if ($myposts -> have_posts()) {
        foreach($myposts -> posts as $key => $post){
          $id = $post -> ID;
          $title = $post -> post_title;
          $status = $post -> post_status;
          $view_auth_level = ($post -> view_auth_level) ?: 0;
          $view_auth_term_id = ($post -> view_auth_term_id);
          $form_id = "form_" . "$key";
          echo("<form id='$form_id' method='post'>
            <tr>
              <td> $title </td>
              <td> $status </td>
              <td>
                <select name='view_auth_term_id' form='$form_id'>
                  <option></option>
                  <optgroup label='Tags'>
          ");
          foreach($tag_terms as $_term_id => $_name) {
            if ($view_auth_term_id == $_term_id) {
              echo("<option value='$_term_id' selected>$_name</option>");
            } else {
              echo("<option value='$_term_id'>$_name</option>");
            }
          }
          echo("
                  </optgroup>
                  <optgroup label ='Categories'>
          ");
          foreach($category_terms as $_term_id => $_name) {
            if ($view_auth_term_id == $_term_id) {
              echo("<option value='$_term_id' selected>$_name</option>");
            } else {
              echo("<option value='$_term_id'>$_name</option>");
            }
          }
          echo("
                  </optgroup>
                  <optgroup label ='Others'>
          ");
          foreach($other_terms as $_term_id => $_name) {
            if ($view_auth_term_id == $_term_id) {
              echo("<option value='$_term_id' selected>$_name</option>");
            } else {
              echo("<option value='$_term_id'>$_name</option>");
            }
          }
          echo("
                  </optgroup>
                </select>
              </td>
              <td>
                <input name='view_auth_level' type='number' value='$view_auth_level' from='$form_id'/>
              </td>
              <td>
                <input type='hidden' name='id' value='$id'/>
                <input type='submit' form='$form_id' value='Save'/>
              </td>
            </tr>
          </form>");
        }
      }
    ?>
    </tbody>
  </table>
</div>
