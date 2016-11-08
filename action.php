<?php 
require('inc/db.php');
$res = $c->prepare("INSERT INTO comments (pid,user,comment) VALUES(?,?,?)");
$res->execute();
 ?>