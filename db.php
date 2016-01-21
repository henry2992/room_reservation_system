<?php
 $link = mysql_connect('cnaiman.com', '4e1e1c335c7c', '2f73cca080ee7e56');
  if (!$link) {
      die('Not connected : ' . mysql_error());
  }

  $db_selected = mysql_select_db('fall15-groupsix', $link);
  if (!$db_selected) {
      die ('Can\'t use myDB: ' . mysql_error());
  }
?>