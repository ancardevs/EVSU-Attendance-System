<?php

function OpenConn()
    {
        /*$server = 'sql300.epizy.com';
        $user = 'epiz_23357863';
        $pass = 'vecTczJYHxzgF';
        $dbase = 'epiz_23357863_dborg';*/

        $server = 'localhost';
        $user = 'root';
        $pass = '';
        $dbase = 'epiz_23357863_dborg';

        $dbconn = new mysqli($server,$user,$pass,$dbase) or die("Connection failed: %s\n".$dbconn -> error);

        return $dbconn;
    }

    function CloseConn($dbconn){
        $dbconn -> close();
    }

?>
