<?php
//error_reporting(E_ALL);
$url= !isset($_REQUEST["url"]) ? "hoge":$_REQUEST["url"];
$key= !isset($_REQUEST["key"]) ? "hoge":$_REQUEST["key"];
$str= !isset($_REQUEST["str"]) ? "hoge":$_REQUEST["str"];
$time = !isset($_REQUEST["time"]) ? "3.3":$_REQUEST["time"];

try{
$dsn ='sqlite:/home/seijiro/nc/bin/nc.db';    
$objPdo = new PDO($dsn, "", "");
$objPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$objPdo->exec("SET CHARACTER SET utf8");
$sql = "INSERT INTO loglog(`key`,url,str,`time`) VALUES(:ky,:ur,:st,:ti); ";
$stmt = $objPdo->prepare($sql);

$stmt->bindValue(':ur', $url, PDO::PARAM_STR);
$stmt->bindValue(':ky', $key, PDO::PARAM_STR);
$stmt->bindValue(':st', $str, PDO::PARAM_STR);
$stmt->bindValue(':ti', $time, PDO::PARAM_STR);

$stmt->execute();

} catch(Exception $e) {
    trigger_error($e->getMessage());
    echo $e->getMessage();
}

echo "ok.";
