<?php

$comport = "COM8";

function OpenConn()
    {
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
