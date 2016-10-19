<?php

function get_s($url,$id)
{
    $ch = curl_init($url);
    $fp = fopen($id.'_source.txt', "w");

    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
}

function db_connect()
{
    $link = mysqli_connect('localhost', 'user', 'password', 'search');
    if(!$link)
        die('DB error');
   
    mysqli_select_db($link,'search');

    return $link;
}

function get_url()
{
    $link = db_connect();

    $id = get_id_file();

    $query = mysqli_query($link, "SELECT URL FROM pages WHERE ID='$id';");
    $urls = mysqli_fetch_array($query);

    mysqli_close($link);
    $u = $urls[0];
    return $u;
}

function get_id()
{
    $link = db_connect();

    if($res = mysqli_prepare($link,"SELECT * FROM PAGES"))
    {
        mysqli_stmt_execute($res);
        mysqli_stmt_store_result($res);
        $n = mysqli_stmt_num_rows($res);
        mysqli_stmt_close($res);
    }
    mysqli_close($link);
    return $n;
}

function get_id_file()
{
    $x = 1;

    while(file_exists($x.'_source.txt'))
    {
        $x++;
    }
return $x;
}

function db_entry($url)
{

    $link = db_connect();

    $id = get_id();
    $id += 1; 
    $query = mysqli_query($link, "SELECT URL FROM pages");
        
    $flag = 0;

    while ($urls = mysqli_fetch_array($query,MYSQL_ASSOC))
    {
        if ($urls[URL]==$url)
            $flag=1;
    }

    if($flag==0)
        mysqli_query($link, "INSERT INTO pages (ID, URL) VALUES ('$id', '$url');");

    mysqli_close($link);
}

function detect_link($id)
{
    if (file_exists($id.'_source.txt'))
        $hfile = fopen($id.'_source.txt','r');
    if($hfile){
        while(!feof($hfile)){
            $html.=fgets($hfile,1024);
        }
    }
            
    preg_match_all('/a[\s]+[^>]*?href[\s]?=[\s\"\']+(.*?)[\"\']+.*?>([^<]+|.*?)?<\/a>/i', $html, $matches);       

    $matches = $matches[1];

    foreach($matches as $var)
    {   
        if(preg_match_all('/([\w\.]+\.(\S)(\S)[^,\s]*)/is',$var,$match)) 
            db_entry($var);
    }
}

function db_travel($id)
{
    $link = db_connect();
    $id=$id;
    while($i<=get_id())
    {
        $qurl = mysqli_query($link, "SELECT URL FROM pages WHERE ID > $id;");
        $urls = mysql_fetch_array($qurl);

        foreach ($urls as $url)
        {
            
        }
    }
}

?>