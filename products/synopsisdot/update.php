<?php
  if(!$Connect=mysql_connect("MySQLB5.webcontrolcenter.com","inovius","graceabc1A")){
    die("Could not connect: ".mysql_error());exit;}
  if(!mysql_select_db("synopsisdot",$Connect)){
    echo"Could not select database.";exit;}
  if(!$Query=mysql_query(
    "select password
    from customer
    where email='".$_POST["Email"]."'",$Connect)){
      echo"DB Error, could not query the database\n";
      echo"MySQL Error: ".mysql_error();exit;}
  if($Result=mysql_fetch_assoc($Query)){
    if(crypt($_POST["Password"],$Result["password"])==$Result["password"]){
      if($_POST["Who"]){
        mysql_query(
          "update inventory set who='".$_POST["Who"]."'
          where inventory_id=".$_POST["inventory_id"]);}
      if($_POST["What"]){
        mysql_query(
          "update inventory set what='".$_POST["What"]."'
          where inventory_id=".$_POST["inventory_id"]);}
      if($_POST["Where"]){
        mysql_query(
          "update inventory set `where`='".$_POST["Where"]."'
          where inventory_id=".$_POST["inventory_id"]);}
      if($_POST["When"]){
        mysql_query(
          "update inventory set `when`='".$_POST["When"]."'
          where inventory_id=".$_POST["inventory_id"]);}
    }
    else{echo"Sorry, but those login credentials are invalid.";}}
  else{echo"Sorry, but those login credentials are invalid.";}
  mysql_free_result($Query);
  mysql_close($Connect);
?>