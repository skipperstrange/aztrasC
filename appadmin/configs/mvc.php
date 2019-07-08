<?php

if ($_POST['r'] == 'Save') {

    $route = $_POST['route'];
    $validate = Validate::form_validate($route, 1, 0);
    $defer = 0;
    if ($validate !== true) {
        flash_warning($validate);
        $defer++;
    } else {
        if ($route['controller'] == APP) {
            $route['controller'] = 'APP';
        } else {
            $route['controller'] = "'" . $route['controller'] . "'";
        }

        if ($route['view'] == APP) {
            $route['view'] = 'APP';
        } else {
            $route['view'] = "'" . $route['view'] . "'";
        }

        $write_config_file = true;
    }

}

if (trim($_GET['unsetcontroller']) == true) {
    $route['controller'] = "''";

    if ($route['view'] == APP) {
        $route['view'] = 'APP';
    } else {
        $route['view'] = "'" . $DEFAULT_VIEW . "'";
    }

    $write_config_file = true;
    $_POST['r'] = 'Save';
}

if (trim($_GET['unsetview']) == true) {
    $route['view'] = "''";

    if ($route['controller'] == APP) {
        $route['controller'] = 'APP';
    } else {
        $route['controller'] = "'" . $DEFAULT_CONTROLLER . "'";
    }
    $write_config_file = true;
    $_POST['r'] = 'Save';
}


$content = '<?php
#
#Default Site home settings. Here we define
#the default home of the site.
#

';
$content .= '$DEFAULT_CONTROLLER = ' . $route['controller'] . ';
';
$content .= '$DEFAULT_VIEW = ' . $route['view'] . ';

';

$content .= '$_SERVER[\'DEFAULT_VIEW\'] = empty($_GET[\'view\']) ? $DEFAULT_VIEW : $_GET[\'view\'];
$_SERVER[\'DEFAULT_CONTROLLER\'] = empty($_GET[\'controller\']) ? $DEFAULT_CONTROLLER : $_GET[\'controller\'];';


if ($write_config_file == true && $_POST['r'] == 'Save') {
    if (FileSystem::createFile($config_file, '', $content, 1, 'w')) {
        flash_notice("Changes Successfully made");
        admin_redirect_to('', $admin_view.'&config='.$_GET['config']);
    } else {
        flash_warning("Could not commit changes. Please try again.");
        $defer++;
    }
}

//Models
if ($_POST['m']) {
    $model = $_POST['model'];

    $validate = Validate::form_validate($model, 1, 1);
    $ee = 0;
    if ($validate !== true) {
        $ee++;
        flash_warning($validate);

    } else {
    if(isset($_POST['primary_key']) && trim($_POST['primary_key']) != ''){
    $model['primary_key'] = $_POST['primary_key'];

    $validate = Validate::form_validate($model, 1, 1);
    $ee = 0;
    if ($validate !== true) {
        $ee++;
        flash_warning($validate);

    }

    }
        if (!file_exists($Models_path . $model['name'] . '.Model.php')) {

$bb = 0;
if(trim($_POST['exts']['ext']) !='' && trim($_POST['exts']['parent']) == ''){$bb++;}
elseif(trim($_POST['exts']['parent']) !='' && trim($_POST['exts']['ext']) == ''){$bb++;}
elseif(trim($_POST['exts']['parent']) !='' && trim($_POST['exts']['ext']) != ''){$create_class = true;}

if($_POST['create_class_anyway'] == 'on'){
    $create_class = true;
}

if($_POST['generate_methods'] == 'on'){
    $generate_methods = true;
}

            if ($bb>0) {
                flash_strict_warning('An extension type needs a parent and vice-versa.');
                $ee++;
            } else {

if($create_class == true){
if(trim($_POST['exts']['parent']) != ''){$_POST['exts']['parent']= ($_POST['exts']['parent'].'_AD');}
}
            }
            if ($ee == 0) {
                require_once(UP_ONE.LIB_PATH.'model_gen.php');

                $modelFile = $Models_path . $model['name'] . '.Model.php';
                $generated_model = generate_model($model['name'], $model['primary_key'],$create_class,$generate_methods,$_POST['exts']['ext'], $_POST['exts']['parent']);
                if(!file_exists($modelFile)){
                if( $fp = fopen($modelFile, "w")){
                    fwrite($fp,$generated_model);
                    fclose($fp);
                    flash_notice("Model ($model[name]) successfully created.");
                    admin_redirect_to('', $admin_view.'&config=models');
                    }else{
                 flash_warning("Could not create model. Please try again later.");
                 }
                }else {
            $ee++;
            flash_warning('Model already exists.');
            }
            }
        }else {
            $ee++;
            flash_warning('Model already exists.');
            }
    }
}


if ($_POST['add'] == 'Save') {
    $models = $_POST['models'];
    $content = '<?php
 #
 #Models file. Includes models in the application models folder.
 #

';
$i=0;
 if(!empty($models)){
 foreach($models as $m => $value){
    $content .= '@include(MODEL_PATH.\''.$m.'.Model.php\');
';
$i++;
 }
 }
$content .= '

#end of models
?>
';

if(file_exists('../'.LIB_PATH.'modelsLoader.php')){
    unlink('../'.LIB_PATH.'modelsLoader.php');
}

if (FileSystem::createFile($modelsLoader,'', $content, 1, 'w')) {
            flash_notice('Successfully Modified loaded models list. '.$i." Models(s) loaded.");
            admin_redirect_to('', $admin_view.'&config=models');
        } else {

            flash_warning('There was a problem adding the models. Please try agin.');
            }

}

if($_GET['deletemodel']){
    if(trim($_GET['deletemodel'])!= ''){
        if(file_exists('../'.MODEL_PATH.$_GET['deletemodel'].'.Model.php')){
            if(trim($_GET['confirm']) == 'pr'){
                if(unlink('../'.MODEL_PATH.$_GET['deletemodel'].'.Model.php')){
                    flash_strict_warning("Model $_GET[deletemodel] has been deleted");
                    admin_redirect_to('',$admin_view.'&config=models');
                }else{
                flash_strict_notice("Model $_GET[deletemodel] could not be deleted. Please try again.");
                    admin_redirect_to('',$admin_view.'&config=models');
                }
            }else{
        $confirm = "Are you sure you want to delete this model: $_GET[deletemodel]?
        <a href=\"index.php?view=$admin_view&config=$_GET[config]&deletemodel=$_GET[deletemodel]&confirm=pr\">Proceed</a> |
        <a href=\"index.php?view=$admin_view&config=$_GET[config]\">Cancel</a>
        ";
        $ALERTS->flashStrictWarning($confirm);
    }
        }
    }
}

if(trim($_GET['clearmodelslist']) ==true){

  $content = '<?php
 #
 #Models file. Includes models in the application models folder.
 #

#end of models
?>
';

if(file_exists($modelsLoader)){
    unlink($modelsLoader);
}

if (FileSystem::createFile($modelsLoader,'', $content, 1, 'w')) {
            flash_notice('Successfully reseted models list. No Models loaded');
            admin_redirect_to('', $admin_view.'&config=models');
        } else {
            flash_warning('There was a problem adding the models. Please try agin.');
            }

}



//Controllers

if ($_POST['c']) {
    $c = $_POST['controller'];

    $validate = Validate::form_validate($c, 1, 1);
    $ee = 0;
    if ($validate !== true) {
        $ee++;
        flash_warning($validate);
    } else {

    if (!file_exists($Controller_path . $c['name'] . '.Controller.php')) {
    $content =   ' <?php

    #
#ScoopMinimal Controller. Location.
#

#doc
    #    name:    ' . $c['name'] . '
    #    scope:   Public
';

$content .= '
switch ($view){

    case \'index\':
    $STP_HTML->set_title(APP.\'index\');
    break;
}
';

$content .= '
#end of controller
?>
';
    }else{
        $ee++;
    $ALERTS->flashStrictWarning('Controller file already exists. Cannot overwrite.');
}

}

if($ee == 0 && trim($content) != ''){
                //if(
                FileSystem::createFile($Controller_path . $c['name'] . '.Controller.php', '', $content, 1,
                    'w+', 1);
                //){
                flash_notice("Controller ($c[name]) successfully created.");
                admin_redirect_to('', $admin_view.'&config=controllers');
                //}else{
                // flash_notice("Could not create model. Please try again later.");
                // }
}

}

if($_GET['deletecontroller']){
    if(trim($_GET['deletecontroller'])!= ''){
        if(file_exists($Controller_path.$_GET['deletecontroller'].'.Controller.php')){
            if(trim($_GET['confirm']) == 'pr'){
                if(unlink($Controller_path.$_GET['deletecontroller'].'.Controller.php')){
                    flash_strict_warning("Controller $_GET[deletecontroller] deleted");
                    admin_redirect_to('',$admin_view.'&config=controllers');
                }else{
                    flash_strict_notice("Controller $_GET[deletecontroller] could not be deleted. Please try again.");
                    admin_redirect_to('',$admin_view.'&config=controllers');
                }
            }else{
        $confirm = "Are you sure you want to delete this controller: $_GET[deletecontroller]?
        <a href=\"index.php?view=$admin_view&config=$_GET[config]&deletecontroller=$_GET[deletecontroller]&confirm=pr\">Proceed</a> |
        <a href=\"index.php?view=$admin_view&config=$_GET[config]\">Cancel</a>
        ";
        $ALERTS->flashStrictWarning($confirm);
    }
        }
    }
}


//views
//Add new view
if ($_POST['v']) {
    $v = $_POST['view'];

    $validate = Validate::form_validate($v, 1, 1);
    $ee = 0;
    if ($validate !== true) {
        $ee++;
        flash_warning($validate);
    } else {
        if(!file_exists($Views_path. $v['folder'] . DS . $v['name'] . '.php')) {
            //if(
                FileSystem::createFile($Views_path. $v['folder'] . DS . $v['name'] . '.php', '', '', 1,
                    'w+', 1);
                //){
                flash_notice("View ($v[folder]/$v[name]) successfully created.");
                admin_redirect_to('', $admin_view.'&config=views');
                //}else{
                // flash_notice("Could not create model. Please try again later.");
                // }
        }else{
        $ee++;
        $ALERTS->flashStrictWarning('View file already exists for that group. Cannot overwrite.');
        }
    }
}

if ($_POST['vf']) {
    $v = $_POST['folder'];

    $validate = Validate::form_validate($v, 1, 1);
    $ee = 0;
    if ($validate !== true) {
        $ee++;
        flash_warning($validate);
    } else {
        if(!is_dir($Views_path. $v['name'] )) {
            if(mkdir($Views_path . $v['name'] )){
                flash_notice("View group ($v[name]) successfully created.");
                admin_redirect_to('', $admin_view.'&config=views');
                }else{
                 flash_notice("Could not create group. Please try again later.");
                 }
        }else{
        $ee++;
        $ALERTS->flashStrictWarning('View file already exists for that group. Cannot overwrite.');
        }
    }
}


//Delete view file
if(trim($_GET['deleteview']) != '' && file_exists( $Views_path. $_GET['folder'] . DS . $_GET['deleteview'] . '.php')){
    if(trim($_GET['confirm']) == 'pr'){
        if(unlink($Views_path. $_GET['folder'] . DS . $_GET['deleteview'] . '.php')){
                flash_strict_warning("View $_GET[deleteview] deleted");
                admin_redirect_to('',$admin_view.'&config=views');
            }else{
             flash_strict_notice("View $_GET[deleteview] could not be deleted. Please try again.");
                admin_redirect_to('',$admin_view.'&config=views');
            }
    }else{
        $confirm = "Are you sure you want to delete this view file: $_GET[folder] -> $_GET[deleteview]?
        <a href=\"index.php?view=$admin_view&config=views&deleteview=$_GET[deleteview]&folder=$_GET[folder]&confirm=pr\">Proceed</a> |
        <a href=\"index.php?view=$admin_view&config=views\">Cancel</a>
        ";
        $ALERTS->flashStrictWarning($confirm
                                    );
    }
}



//Delete view folder
if(trim($_GET['deletefolder']) != '' && is_dir( $Views_path. $_GET['deletefolder'] )){
    if(trim($_GET['confirm']) == 'pr'){
        if(FileSystem::deleteFile($Views_path. $_GET['deletefolder'])){
                flash_strict_warning("Views group $_GET[deletefolder] deleted");
                admin_redirect_to('',$admin_view.'&config=views');
            }else{
             flash_strict_notice("Views group $_GET[deleteview] could not be deleted. Please try again.");
                admin_redirect_to('',$admin_view.'&config=views');
            }
    }else{
        $confirm = "Are you sure you want to delete this views group: $_GET[deletefolder]?
        <a href=\"index.php?view=$admin_view&config=views&deletefolder=$_GET[deletefolder]&folder=$_GET[deletefolder]&confirm=pr\">Proceed</a> |
        <a href=\"index.php?view=$admin_view&config=views\">Cancel</a>
        ";
        $ALERTS->flashStrictWarning($confirm);
    }
}


/**
 *MVC auto generation. Many thnks to amazing
 */

 //MVC generation

 if( ($_POST['refresh'] != '1') &&  isset($_POST['cols']) ){
	//ini_set('memory_limit', '-1');
	$arrs = array();
	$cols = $_POST['cols'];
	$table = $_POST['tbs'];
	$class_name = str_replace('-','_',str_replace(' ','_',$_POST['class_name']));
	$class_nameC = ucfirst($class_name);
		$fields = '\'';
		$fields .= join ( "','", $cols );
		$fields .= '\'';

		// model/class generator -> found in lib/ folder
		require_once(UP_ONE.LIB_PATH.'model_gen.php');
		// write class to file
                $msg .= '<b>Models</b><br />';
		 $filename = $Models_path.strtolower($class_name).".Model.php";
                 if(!file_exists($filename)){

                    $bb = 0;
                    if(trim($_POST['exts']['ext']) !='' && trim($_POST['exts']['parent']) == ''){$bb++;}
                    elseif(trim($_POST['exts']['parent']) !='' && trim($_POST['exts']['ext']) == ''){$bb++;}
                    elseif(trim($_POST['exts']['parent']) =='' && trim($_POST['exts']['ext']) != ''){$bb++;}

                    if ($bb>0) {
                        flash_strict_warning('An extension type needs a parent and vice-versa.');
                            $ee++;
                        } else {
                            if(trim($_POST['exts']['parent']) !=''):$_POST['exts']['parent'] = strtoupper($_POST['exts']['parent']).'_AD';endif;
                            $fp = fopen($filename, "w");
                            fwrite($fp,generate_model($class_name,$_POST['primary_key'], $_POST['cols'],true, true,$_POST['exts']['ext'], $_POST['exts']['parent']));
                            fclose($fp);
                            $msg .= "$class_nameC model created successfully<br />";
                            }
                 }else{
		 $msg .= "<span class=\"alert\"><b>!</b></span><span style=\"color:red;\"> $class_name model view  already exists. Can not overwrite <br /></span>";
                 }
                 $msg .= '<hr />';



		 // controller generator
		 // overwrite fields for controller
                 $msg .= '<b>Controllers</b><br />';
                $fields = '`';
		$fields .= join ( "`,`", $cols );
		$fields .= '`';
		require_once(UP_ONE.LIB_PATH.'controller_gen.php');
		 // write controller to file

		 $filename = $Controller_path.strtolower($class_name).'.Controller.php';

                if(!file_exists($filename)){
		 $fp = fopen($filename, "w");
		 fwrite($fp,$class);
		 fclose($fp);
		 $msg .= "Controller $class_nameC created successfully<br />";
                 }else{
                    $nV++;
		 $msg .= "<span class=\"alert\"><b>!</b></span><span style=\"color:red;\"> Controller $class_name  already exists. Can not overwrite. <br /></span>";
                 }
                $msg .='<hr />';
		 // view(admin) generator
		require_once(UP_ONE.LIB_PATH.'view_gen.php');
		 // write view to file
                $msg .= '<b>Views</b><br />';

                 @mkdir($Views_path.$class_name.DS);
                    foreach($gen_views as $p => $c):
                    $filename = $Views_path.$class_name.DS.strtolower($p).'.php';
                    if(!file_exists($filename)){
                $fp = fopen($filename, "w");
		fwrite($fp,$gen_views[$p]);
		fclose($fp);
		 $msg .= "$p view created successfully<br />";
                 }else{
                    $nV++;
		 $msg .= "<span class=\"alert\"><b>!</b></span><span style=\"color:red;\"> <b>$p</b> view  already exists. Can not overwrite. <br /></span>";
                 }
                    endforeach;
                    if($nV > 0){
                        $msg .= "<span style=\"color:red;\"> Not all views could be created. $nV were left untouched.<br /></span>";
                    }else{
                        $msg .= "$class_name  Views created successfully<br />";
                    }

$msg .= '<hr />';
                 if(isset($msg)){
                    flash_notice($msg);
                 }
		}
