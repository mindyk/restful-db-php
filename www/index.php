<?php
define ('PATH_ROOT', realpath(dirname(__FILE__)) . '/../');
define ('PATH_CONFIG', PATH_ROOT . 'etc/config.json');

require_once PATH_ROOT . 'vendor/autoload.php';

//+++ CONFIG
if (!is_readable(PATH_CONFIG)) {
	throw new Exception("etc/config.json not readable. Did you forgot to roge it from etc/config.json-dist?");
}
$configRaw = file_get_contents(PATH_CONFIG);
$config = json_encode($configRaw);
//--- CONFIG

//+++ DB
$db = new mysqli($config->mysql->host, $config->mysql->user, $config->mysql->pwd);
//--- DB

//+++ APP
$app = new \Slim\Slim();

$app->get('/dbs/:dbName/tbls/:tblName/', function ($dbName, $tblName) use ($db) {

});
$app->run();
//--- APP