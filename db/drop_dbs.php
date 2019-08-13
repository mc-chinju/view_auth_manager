<?php
use Illuminate\Database\Capsule\Manager as Capsule;

class DropDbs
{
    public static function execute()
    {
        $capsule = new Capsule;
        $schema = $capsule->schema();

        $schema->dropIfExists("vam_progresses");
    }
}
