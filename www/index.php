<?php
define ('PATH_ROOT', realpath(dirname(__FILE__)) . '/../');
define ('PATH_CONFIG', PATH_ROOT . 'etc/config.json');

require_once PATH_ROOT . 'vendor/autoload.php';

//+++ CONFIG
if (!is_readable(PATH_CONFIG)) {
	throw new Exception("etc/config.json not readable. Did you forgot to forge it from etc/config.json-dist?");
}
$configRaw = file_get_contents(PATH_CONFIG);
$config = json_decode($configRaw);
//wwwDebug($config);
//--- CONFIG

//+++ DB
$db = new mysqli($config->mysql->host, $config->mysql->user, $config->mysql->pwd);
//--- DB

//+++ APP
$app = new \Slim\Slim();
$app->get('/', function () {
	echo '<h1> ROOT</h1>';
});

$app->get($config->prefix, function () {
	echo '<h1> RESTFUL DB API</h1>';
});
$app->get($config->prefix . '/dbs/:dbName/tbls/:tblName', function ($dbName, $tblName) use ($app, $db) {
	$result = $db->query(sprintf("EXPLAIN %s.%s", $dbName, $tblName));
	$resultAsArray = array();
	while ($row = $result->fetch_assoc()) {
		$resultAsArray[$row['Field']] = $row;
	}
	wwwDebug($resultAsArray);
	$sort = $app->request->get('sort');
	$fields = $app->request->get('fields');
	$page = $app->request->get('page');
	$perPage = $app->request->get('perPage');

	$filters = array();

	foreach ($resultAsArray as $key => $col) {
		$filterValue = $app->request->get($key);
		if (!empty($filterValue)) {
			$filters[$key] = $filterValue;
		}
	}

	$request = array(
		'sort' => $sort,
		'fields' => $fields,
		'page'	=> $page,
		'per_page' => $perPage,
		'filters' => $filters,
	);

	wwwDebug($request);
});
$app->run();
//--- APP

function wwwDebug($value)
{
	echo '<pre>' . print_r($value, true) . '</pre>';
}
