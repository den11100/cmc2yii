<?php


$localConfigPath = __DIR__ . DIRECTORY_SEPARATOR . 'db.local.php';

$localConfig = [];
if (file_exists($localConfigPath)) $localConfig = require $localConfigPath;

$params = require(__DIR__ . '/params.php');

$config = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=cmc2test',
    'username' => 'root',
    'password' => '111111',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

return \yii\helpers\ArrayHelper::merge($config, $localConfig);
