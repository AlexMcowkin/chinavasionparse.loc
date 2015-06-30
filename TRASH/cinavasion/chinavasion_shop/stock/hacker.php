<?php
$connect = mysql_connect("openserver:3306","root","") or die('No connection');
mysql_query('SET NAMES utf8');
mysql_select_db("electronix",$connect) or die('No connection!');
?>