<?php
  use Illuminate\Database\Capsule\Manager as Capsule;

  class CreateProgresses {
    public static function change() {
      $capsule = new Capsule;
      $schema = $capsule->schema();

      if (!$schema->hasTable('vam_progresses')) {
        $schema->create('vam_progresses', function($table) {
          $table->bigIncrements('id');
          $table->Integer('level')->default(0);
          $table->bigInteger('user_id');
          $table->bigInteger('term_id');
          $table->timestamps();
        });
      }
    }
  }
 ?>
