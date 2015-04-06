<?php
session_start();

function authenticate() {
    if ($_SERVER['PHP_AUTH_USER'] != "" && $_SERVER['PHP_AUTH_PW'] != "") {
        if ($_SERVER['PHP_AUTH_USER'] == "airtime" && $_SERVER['PHP_AUTH_PW'] == "Airtime2015$"){
            return 1; //Return anything other than NULL to indicate success
        }
    }
    header('WWW-Authenticate: Basic realm="AirTime"');
    header('HTTP/1.0 401 Unauthorized');
    return NULL;
}

if (($result = authenticate()) == NULL) {
    echo("You are not authorized to view this page");
    exit(0); //Authorization Failed
}

?>