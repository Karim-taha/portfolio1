<?php 

include 'lib/functions.php';

$setting_id = $_GET['setting_id'];
if(!empty($setting_id)){
    updateSettings($setting_id);
}else{
    echo "Something is wrong.";die();
}




