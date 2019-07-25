<?php
  function vam_install_data() {
    global $wpdb;

    $welcome_name = 'Wordpress さん';
    $welcome_text = 'おめでとうございます、インストールに成功しました！';

    $table_name = $wpdb -> prefix . "vam_progresses";

    $wpdb->insert(
      $table_name,
      array(
        'time' => current_time( 'mysql' ),
        'name' => $welcome_name,
        'text' => $welcome_text,
      )
    );
  }
?>
