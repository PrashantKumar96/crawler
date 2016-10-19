<?php

require_once('header.php');

$a = 1;
$passes = 1;
while($a)
{
    $id = get_id_file();
    echo 'GET_ID_FILE: '.$id.'<br>';

    $url = get_url();

    if(!$id)
        die('Set initial values in DB');

    if(!$url)
        die('End!');

    if (!file_exists($id.'_source.txt'))
        {
            echo 'GET_URL: '.$url.'<br>';
            get_s($url,$id);
            detect_link($id);
            db_travel($id);
            echo 'Pass '.$passes.'<br>**********************************************************<br>';
            $passes+=1;
        }
    else
        $a = 0;
}

?>