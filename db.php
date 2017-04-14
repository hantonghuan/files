<?php

define('TABLE', "source");

$host = '10.75.18.150';
$port = '5040';
$db = 'topweibo';
$user = 'topweibo';
$passwd = 'f3u4w8n7b3h';


$pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $passwd);

$source_id = file('source_id');
foreach ($source_id as $k => $id) {
	$source_id[$k] = get_score((int)$id);
	file_put_contents('score', $source_id[$k]['source']."\n", FILE_APPEND);
}

function get_score($id) {
	$sql = "select source, score from " . TABLE . " where source_id=$id";
	$result = $pdo->query($sql)->fetchAll();
	return [
		'id' => $id,
		'source' => $result[0]['source'],
		'score' => $result[0]['score']
	];
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

