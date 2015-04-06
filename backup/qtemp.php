<?php
require("auth_admin.php");
require("APIClient.php");
require("config.php");


$api = new APIClient();

$uuid = "111";
$major = "111";
$minor = "1112";
$brand = "111";
$model = "111";

$api->addBeacon($uuid,$major,$minor,$brand,$model);

?>
<html>
<h1>Test</h1>

</html>