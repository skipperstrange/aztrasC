<?php

/**
 * @author skipper
 * @copyright 2011
 */

/*****************************************
///////////////////////////////////////////
System wide classes can be included here

///////////////////////////////////////////
******************************************/
class Autoload
{


    static public function appModels()
    {
        PhpFileSys::require_all_files_once(MODEL_PATH);
    }
    
     static public function loadExtModels($path_to_models)
    {
        PhpFileSys::require_all_files_once($path_to_models);
    }
    
    
    function loadAppModel($model){

    if(file_exists(MODEL_PATH.$model.MODEL_EXT)){
        @include_once MODEL_PATH.$model.MODEL_EXT;
    }else{
        echo "<p>Error loading model. $model does not exist in application's models.</p>";
    }
    return true;
    }
    
    static public function loadExtModel($path_to_model)
    {
        if(file_exist($path_to_models)){
			require_once($path_to_models);
		}else{
		echo "Model file does not exist ->($path_to_models)";
		}
    }

}
