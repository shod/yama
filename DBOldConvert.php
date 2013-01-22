<?php
ini_set('max_execution_time ', 999999999999);
include_once 'functions.php';

$db = mysql_connect('localhost', 'root', '');
mysql_select_db('test4migomby', $db);

$res = mysql_query('select * from users2 where 1 group by email');

while($user = mysql_fetch_assoc($res)){
    $flagOk = true;
    $resRepeats = mysql_query('select * from users2 where email = "'. $user['email'] .'" AND id != ' . $user['id'] .'');
    while($repeat = mysql_fetch_assoc($resRepeats)){
        if(!mysql_query('update news_comments2 set user_id = ' . $user['id'] .' where user_id = '.$repeat['id'])){
            dd('update news_comments2 set user_id = ' . $user['id'] .' where user_id = '.$repeat['id']);
            $flagOk = false;
        }
    }
    if($flagOk){
        if(!mysql_query('delete from users2 where email = "' . $user['email'] .'" AND id != '.$user['id'])){
            dd('delete from users2 where email = "' . $user['email'] .'" AND id != '.$user['id']);
        }
    }
}