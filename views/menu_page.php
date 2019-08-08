<div class="wrap">
  <h2>View Auth Manager</h2>
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
