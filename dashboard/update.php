<?php 

include 'lib/functions.php';

$project_id = $_GET['portfolio_id'];
if(!empty($project_id)){
    updatePortfolio($project_id);
}else{
    echo "Something is wrong.";die();
}




