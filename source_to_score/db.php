<?php

define('TABLE', "source");

$host = '10.75.18.150';
$port = '5040';
$db = 'topweibo';
$user = 'topweibo';
$passwd = 'f3u4w8n7b3h';


$pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $passwd);

$data = file('source_id');
foreach ($data as $k => $id) {
	$data[$k] = get_score((int)$id, $pdo);
	file_put_contents('source_id.txt', $data[$k]['source_id']."\n", FILE_APPEND);
	file_put_contents('source.txt', $data[$k]['source']."\n", FILE_APPEND);
	file_put_contents('score.txt', $data[$k]['score']."\n", FILE_APPEND);
}


function get_score($id, $pdo) {
	$sql = "select source_id, source, score from " . TABLE . " where source_id=$id";
	$result = $pdo->query($sql)->fetchAll();
	return $result[0]; 
}
