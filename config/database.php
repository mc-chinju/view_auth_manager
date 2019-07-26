<?php
require_once(ABSPATH . "wp-content/plugins/view_auth_manager/vendor/autoload.php");

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => '192.168.95.100',
    'database'  => 'local',
    'username'  => 'root',
    'password'  => 'root',
    'port'      => '4002',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => 'wp_',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();
?>