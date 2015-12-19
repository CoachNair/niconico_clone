<?php
error_reporting(E_ALL);

$url= !isset($_REQUEST["url"]) ? "hoge":$_REQUEST["url"];

$dsn ='sqlite:/home/seijiro/nc/bin/nc.db';

$array = array();

try {
  $objPdo = new PDO($dsn, "", "");
  $objPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //$objPdo->exec("SET CHARACTER SET utf8");
  $sql = "select * from loglog where url=:ur order by cdate DESC limit 100;";
  $stmt = $objPdo->prepare($sql);
  $stmt->execute( array(':ur'=>$url) );
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $array[] = $row;
  }
} catch(Exception $e) {
  echo $e->getMessage();
  trigger_error($e->getMessage(),E_USER_NOTICE);
}

header("Content-type: text/xml");
$out = array2xml($array);
trigger_error($out,E_USER_NOTICE);
echo $out;
exit;

function array2xml(&$array){
    //Creates XML string and XML document using the DOM
    $dom = new DomDocument('1.0');
    $posts = $dom->appendChild($dom->createElement('posts'));

    foreach($array as $e){
        $post = $posts->appendChild($dom->createElement('post'));
        foreach($e as $k=>$v){
            $elem = $post->appendChild($dom->createElement($k));
            $elem->appendChild( $dom->createTextNode($v));
        }
    }
    //generate xml
    $dom->formatOutput = true; // set the formatOutput attribute of
    // domDocument to true
    $output = $dom->saveXML();
    return  $output;
}
