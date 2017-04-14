<?php

define('OID', "'1022:2307454073577451289879'");
define('TABLE', "articles_201702");

$host = '10.75.18.150';
$port = '5040';
$db = 'topweibo';
$user = 'topweibo';
$passwd = 'f3u4w8n7b3h';


$pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $passwd);

switch($argc)
{
case 1:
	show($pdo);
	break;
case 2:
	if ($argv[1] == 'push_content') {
		push_content($pdo);
	}
	if ($argv[1] == 'pull_content') {
		pull_content($pdo);
	}

	break;
case 3:
	if($argc == 3) {
		$column = $argv[1];
		$value = $argv[2];
		update_str($pdo, $column, $value);
	}

	if($argc == 4 && $argv[3] == 'int') {
		$column = $argv[1];
		$value = $argv[2];
		update_int($pdo, $column, $value);
	}
	break;

}

function update_str($pdo, $column, $value) {
	$sql = "update " . TABLE  . " set $column=\"$value\" where oid=" . OID;
	if($pdo->exec($sql)) {
		echo "Success!\n";
	}
}

function update_int($pdo, $column, $value) {
        $sql = "update " . TABLE  . " set $column=$value where oid=" . OID;
        if($pdo->exec($sql)) {
                echo "Success!\n";
	}
}

function pull_content($pdo) {
	$sql = "select content from " . TABLE  ." where oid=" . OID;
	$result = $pdo->query($sql)->fetchAll();
	//var_dump($result[0]['content']);
	file_put_contents('content.json', $result[0]['content']);
}

function push_content($pdo) {
	//$article = json_decode(file_get_contents('content.json'), true);
	//$content = json_encode($article['content']);
	$content = file_get_contents('content.json');
	$content = explode("\\",$content);
	$content = implode("\\\\", $content);
	$content = explode("\"",$content);
	$content = implode("\\\"", $content);
	$content = rtrim($content, "\n");
	
	//var_dump($content);
	//exit;
	
	$sql = "update " . TABLE  . " set content=\"$content\" where oid=" . OID;
	if($pdo->exec($sql)) {
		echo "Success!\n";
	}
}

function show($pdo) {
	$sql = "select * from " . TABLE  ." where oid=" . OID;
	$result = $pdo->query($sql)->fetchAll();
	print_r($result);
}

