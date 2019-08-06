<?php
  $postsPerPage = 20;
  $postOffset = $paged * $postsPerPage;

  $args = array(
    "paged" => $paged,
    "posts_per_page" => $postsPerPage,
    "offset" => $postOffset,
    "orderby" => $orderby,
    "order" => $order,
  );
?>

<div class="wrap">
  <h2>View Auth Manager</h2>
  <table class="wp-list-table widefat fixed striped posts">
    <thead>
      <tr>
        <td>Title</td>
        <td>Post Status</td>
        <td>Tag</td>
        <td>View Auth Level</td>
        <td>Edit</td>
      </tr>
    </thead>
    <tbody>

    <?php
      $myposts = new WP_Query($args);
      if ($myposts -> have_posts()) {
        foreach($myposts -> posts as $post){
          $title = $post -> post_title;
          $status = $post -> post_status;
          $view_auth_level = ($post -> view_auth_level) ?: 0;

          echo("<tr>
            <td> $title </td>
            <td> $status </td>
            <td> any tags </td>
            <td> $view_auth_level </td>
            <td><a>Edit</a></td>
          </tr>");
        }
      }
    ?>
    </tbody>
  </table>
</div>
