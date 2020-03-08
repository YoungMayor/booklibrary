<?php

$fileName = "configs.php";

if (!file_exists(__DIR__.DIRECTORY_SEPARATOR.$fileName)){
    echo "ERROR: Your configuration has not been set!";
    echo "On Windows, Run `composer set_winfig` and edit your configuration file in api/config/configs.php";


    echo "NOTE: If you have set up your configuration, avoid running the avoid command as it would reset your configuration to the default";

    exit();
}else{
    require_once $fileName;

    foreach ($_CONFIGS AS $key => $value){
        putenv("$key=$value");
    }

    if (!function_exists("_env")){
        function _env($var, $alt = ""){
            return strlen(getenv($var)) ? getenv($var) : $alt;
        }
    }
}
?>
