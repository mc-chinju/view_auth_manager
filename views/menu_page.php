<?php
  $checked = get_site_option( 'active_twitter' );
  if( empty( $checked ) ){
    $checked = '';
  } else {
    $checked = 'checked="checked"';
  }
?>

<div class="wrap">
  <h2>View Auth Manager</h2>

  <form method="post" action="options.php">

    <?php
      settings_fields( "hello-world-group" );
      do_settings_sections( "default" );
    ?>

    <table class="form-table">
      <tbody>
        <tr>
          <th scope="row"><label for="active_twitter">Twitter</label></th>
          <td>
            <input type="hidden" name="active_twitter" value="0">
            <label for="active_twitter"><input type="checkbox" id="active_twitter" name="active_twitter" size="30" value="1"<?php echo $checked; ?>/>Twitter</input></label>
          </td>
        </tr>
      </tbody>
    </table>

    <?php submit_button(); ?>
  </form>
 </div>
