<?php

function loadAppModel($model){

    if(file_exists(MODEL_PATH.$model.'.Model.php')){
        include MODEL_PATH.$model.'.Model.php';
    }else{
        echo "<p>Error loading model. $model does not exist in application's models.</p>";
    }
    return true;
}



function add_model($model){

$content = '<?php
';
        if(is_array($model)){

        }
}
