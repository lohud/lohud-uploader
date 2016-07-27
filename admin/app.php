<?php

ini_set('display_errors', 1);

  include '/credentials.php'


  //Connect to mysql DB
  $db = new PDO("mysql:host={$dbhost};dbname={$dbname};charset=utf8", $dbuser, $dbpass, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));


  if ($_GET['action'] == 'list'){
    getList();
  } elseif ($_GET['action'] == 'delete') {
    $query = "DELETE FROM {$dbtable} WHERE `id` = {$_GET['value']}";

    $stmt = $db->exec($query);
    if ($stmt = 1){
      unlink('../images/'. $_GET['file']);
      unlink('../images/th_'. $_GET['file']);
      getList();
    }
    else{
      echo 'Something went wrong';
      echo json_encode(array("ok" => false));
    }
  }  

  function getList(){
    global $db;
    global $dbtable;

    $query = "SELECT * FROM {$dbtable} ORDER BY `id` DESC";
    $stmt = $db->query($query);
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($results)){
      // echo 'Something went wrong';
      echo json_encode(array('ok' => true, 'data' => $results));
    }
  }

  

?>