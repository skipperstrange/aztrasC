<?php

$pages = FileSystem::scanDirectory('views/pages');
$controllers = FileSystem::scanDirectory('../' . CONTROLLER_PATH);
$databaseFile = UP_ONE. CONFIG_PATH .'db config.php';


@include $databaseFile;
$config_file = UP_ONE. CONFIG_PATH . 'mvc_settings.php';
//        $modelsLoader = UP_ONE. LIB_PATH . 'modelsLoader.php';
        $Controller_path = UP_ONE. CONTROLLER_PATH;
        $Models_path = UP_ONE.MODEL_PATH;

        $Model_files = FileSystem::scanDirectory(UP_ONE.MODEL_PATH);
        $Controller_files = FileSystem::scanDirectory(UP_ONE. CONTROLLER_PATH);
        $Views_path = UP_ONE.VIEW_PATH;
        $View_folders = FileSystem::scanDirectory($Views_path);

$STP_HTML->set_title('Admin - ' . $admin_view);

switch ($admin_view) {

    case 'home':

        break;


    case 'routes':
        //All actions can be found in the corresponding configs file.
        break;


    case "db_config":
        //All actions can be found in the corresponding configs file.
        $db_file = '../' . CONFIG_PATH . 'db_config.php';
        if (!@include_once ($db_file)) {
            $needed = 1;
        }
        break;


    case "adaptors":
        //All actions can be found in the corresponding configs file.
        $adFolders = FileSystem::folderStructure(UP_ONE. ADAPTORS_PATH);
        break;


    case "mvc":
        //All actions can be found in the corresponding configs file.
        $View_folder_files = array();
        if(!empty($View_folders)){
        foreach($View_folders as $View_folder){
         $View_folder_files[$View_folder] =  FileSystem::scanDirectory($Views_path.$View_folder);
        }
        }

        break;

}

if (file_exists('configs/' . $admin_view . '.php')) {
    include 'configs/' . $admin_view . '.php';
}

?>