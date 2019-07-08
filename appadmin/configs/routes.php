<?php

/**
 * Routes Control settings.
 * Route configurations setettings are handled here
 */

//Backup info.
$backup_folder = 'resources/backups/routes/';
$backUpFolders = FileSystem::scanDirectory($backup_folder);
$BackupFolder = array();

foreach ($backUpFolders as $folder) {
    $BackupFolder[$folder]['backups'] = FileSystem::scanDirectory('resources/backups/routes/' .
        $folder . DS);
}

//end of back up info
//Restore
if (isset($_GET['restore']) && trim($_GET['restore']) == 'true') {
    if ($_GET['type'] && trim($_GET['type']) != '') {
        //make sure backup folder exists
        if (is_dir($backup_folder . $_GET['type'])) {
            $folder = $backup_folder . $_GET['type'] . DS;
            if (file_exists($folder . $_GET['backup'])) {

                if (routes_restore($folder . $_GET['backup'], 1)) {

                    flash_notice("Route backup ($_GET[type]->$_GET[backup]) Successfully loaded. All previous routes lost");
                    admin_redirect_to('', 'routes');
                }
            }
        } else {
            flash_warning("No such route backup type.");
            admin_redirect_to('', 'routes');
        }
    }
}
//end of restore
//deletes
if (isset($_GET['deletbackup']) && trim($_GET['deletbackup']) == 'true') {
    if ($_GET['type'] && trim($_GET['type']) != '') {
        //make sure backup folder exists
        if (is_dir($backup_folder . $_GET['type'])) {

            $folder = $backup_folder . $_GET['type'] . DS;
            if (file_exists($folder . $_GET['backup'])) {

                if (FileSystem::deleteFile($folder . $_GET['backup'])) {
                    flash_warning("Route backup ($_GET[type]->$_GET[backup]) Successfully deleted.");
                    admin_redirect_to('', 'routes');
                }
            }
        } else {
            flash_warning("No such route backup type.");
            admin_redirect_to('', 'routes');
        }
    }
}
if (isset($_GET['deleteallbackups']) && trim($_GET['deleteallbackups']) ==
    'true') {
    $deletes = array();

    foreach ($BackupFolder as $folder => $backUps):
        $deletes[$folder] = 0;

        foreach ($BackupFolder[$folder]['backups'] as $backUp) {
            if (FileSystem::deleteFile($backup_folder . $folder . DS . $backUp)) {
                $deletes[$folder]++;
            }

        }


    endforeach;
    foreach ($deletes as $deleted => $number) {
        $msg .= "<br /><b>Deleted $number backup file from $deleted</b>";
    }
    flash_strict_notice($msg);
    admin_redirect_to('', 'routes');
}
//end of backup
if (!@include_once ('../' . CONFIG_PATH . 'routes.php')) {
    $needed = 1;
}


/** Route Config Settings
 * This part turns route settings on or off
 */
if (isset($_GET['route']) && trim($_GET['route']) != '') {
    $route_setting = ucfirst($_GET['route']);
    if (($route_setting == 'On') or ($route_setting == 'Off')):
        $line = '<?
$_SERVER[\'scRouteConfig\'] = ';
        $line .= "'$route_setting'
";
        $line .= '?>';

        if (FileSystem::createFile('route_settings.php', '../config/', $line, 1, 'w')) {
            flash_notice("Route Mode Successfully turned $route_setting");
            admin_redirect_to('', 'routes');
        }
    endif;
}


/** For creating a new route
 * This is where the post request for handeling and
 * adding the new route to the table is done
 */
if ($_POST['r']) {

    $route = $_POST['route'];

    //if there is no value for The url, defualt value is generated
    if (trim($route['url']) == '' && $route['view'] == '') {
        $route_generated['url'] = '@^$@';
    } else {
        //else generate using generate function
        if (trim($route['url']) == '') {

        } else {
            $route_generated = generate_pretty_url_pattern($route['url']);
        }
    }

    if (trim($route['controller']) != '') {
        $route_generated['controller'] = $route['controller'];
    } elseif (!isset($route['controller']) || trim($route_generated['controller']) ==
    '') {
        $route_generated['controller'] = APP;
        $genDefCont = true;
    }

    if (trim($route['view']) != '') {
        $route_generated['view'] = $route['view'];
    } elseif (!isset($route['view']) || trim($route_generated['view']) == '') {
        $route_generated['view'] = 'index';
        $genDefView = true;
    }

    if (($genDefView == true) && ($genDefCont == true)) {
        $route_generated['url'] = '@^$@';
    }

    if (file_exists('../' . CONTROLLER_PATH . $route_generated['controller'] .
        '.Controller.php') || $route_generated['controller'] == 'APP') {
        $match = 0;
        foreach ($_SERVER['scROUTES'] as $test) {
            if ($test['url'] == $route_generated['url']) {
                $match++;
                break;
            }
        }

        if ($match > 0) {
            $ALERTS->flashStrictWarning('There already is an existing route for the pattern. <p><b>Pattern: </b>' .
                $route_generated['url'] . '</p>');
            $ee++;
        } else {
            if (add_to_routes($route_generated)) {

                if ($_POST['all'] == 'generateall') {

                    $findSlash = $route_generated['url'][(strlen($route_generated['url'])) - 3];

                    if ($findSlash == '/') {
                        $proc_url['url'] = str_replace('/$@', '$@', $route_generated['url']);
                    } else {
                        $proc_url['url'] = str_replace('$@', '/$@', $route_generated['url']);

                    }
                    $proc_url['controller'] = $route_generated['controller'];
                    $proc_url['view'] = $route_generated['view'];

                    $match = 0;
                    foreach ($_SERVER['scROUTES'] as $test) {
                        if ($test['url'] == $proc_url['url']) {
                            $match++;
                            break;
                        }
                    }

                    if ($match > 0) {
                        // Do add rout since it exists
                    } else {
                        if (add_to_routes($proc_url)) {
                            $extra_info = true;
                        }
                    }
                }

                $msgh = 'New route added: Controller->' . $route_generated['controller'] .
                    '. View->' . $route_generated['view'] . '. ';
                if ($extra_info == true) {
                    $msgh .= ' All alternative routes were successfully added.';
                }
                flash_notice($msgh);
                admin_redirect_to('', 'routes');
            }
        }
    } else {
        $ALERTS->flashStrictWarning('The controller ' . $route_generated['controller'] .
            ' does not exist. The route cannot be added.');
        $ee++;
    }

}

/** Resets route table to null
 */
if (trim($_GET['reset']) == 'true') {
    if (empty_routes()) {
        flash_notice('Routing table has been emptied');
        admin_redirect_to('', 'routes');
    }
}


/**
 * Deleting a route
 */
if ($_GET['delete']) {
    $_GET['delete'] = $_GET['delete'];
    if (($_SERVER['scROUTES'][$_GET['delete']]['url'] === '@^$@')) {
        //|| ($_SERVER['scROUTES'][$_GET['delete']]['url'] === '@^home$@') || ($_SERVER['scROUTES'][$_GET['delete']]['url'] === '@^home/$@')
        flash_strict_warning('Cannot delete this route.');
        admin_redirect_to('', $admin_view);
    } else {
        if (key_exists(trim($_GET['delete']), $_SERVER['scROUTES'])) {

            if (trim($_GET['confirm']) == 'pr') {

                if (delete_route(trim($_GET['delete']))) {
                    flash_notice('Successfully deleted route');
                    admin_redirect_to('', 'routes');
                }
            } else {
                $confirm = "Are you sure you want to remove this route configuration?
        <a href=\"index.php?view=$admin_view&delete=$_GET[delete]&confirm=pr\">Proceed</a> |
        <a href=\"index.php?view=$admin_view\">Cancel</a>
        <br /><span class=\"desc\"> This action is irreversible but can be reconfigured</span>";
                $ALERTS->flashStrictWarning($confirm);
            }

        } else {
            flash_strict_warning('No such route id exists.');
            admin_redirect_to('', $admin_view);
        }
    }
}


/**
 * Loading Default routes
 */
if (trim($_GET['default']) == 'true') {

    if (empty_routes()) {
        $rr = 0;
        foreach ($ROUTES_RESET as $reseted) {
            if (add_to_routes($reseted)) {
                $rr++;
            }
        }

        if ($rr == count($ROUTES_RESET)) {
            flash_notice('Successfully loaded default routes');
            admin_redirect_to('', 'routes');
        }
    }
}


/**
 * Backup routes processing
 */
if (isset($_POST['bckp']) && trim($_POST['bckp']) == 'Backup') {
    $err = 0;
    if (trim($_POST['backup']['name']) != '') {
        $validate = Validate::form_validate($_POST['backup'], 1, 2);
        if ($validate !== true) {
            $err++;
            flash_warning($validate);
        } else {
            $backup_file = 'resources/backups/routes/custom/' . $_POST['backup']['name'] .
                '.bkp';
        }
    } else {
        $backup_file = 'resources/backups/routes/undefined/autobackup' . strftime("%Y-%m-%d_%H_%M_%S",
            time()) . '.bkp';
    }

    if (routes_backup($backup_file) === 2) {
        flash_warning("Backup file already exists in the name provided. Use a different name or Delete it first.");
        $err++;
    } else {
        if ($err == 0):
            flash_notice('Routes successfully backed up');
            admin_redirect_to('', $view);
        endif;
    }

}


/**
 * Auto generating routes and pretty urls
 */
if (isset($_GET['autogen']) && trim($_GET['autogen']) == true) {
    if ($_POST['controller']) {

        if (file_exists(UP_ONE . CONTROLLER_PATH . $_POST['controller'] .
            '.Controller.php')) {

            require_once UP_ONE . CONTROLLER_PATH . $_POST['controller'] . '.Controller.php';
            if (class_exists($_POST['controller'])) {
                $class_methods = get_class_methods($_POST['controller']);
                if (check_post_get('p', 'gr')) {

                    $controller = $_POST['controller'];
                    $rw = $_POST['rw'];
                    $_POST['controller'] = '';
                    $_POST['gr'] = '';
                    $_POST['rw'] = '';
                    $routings = ArrayRemoveEmpty($_POST);
                    $routing_urls = array();
                    $match = 0;

                    foreach ($routings as $routes => $route) {
                        if ($routings[$routes]['route'] == 'on') {
                            $url = '?controller=' . $controller . '&view=' . $routes;
                            if (isset($routings[$routes]['params']) && trim($routings[$routes]['params']) !=
                                '') {
                                $url .= '&' . ltrim($routings[$routes]['params'], '?');
                            }
                            $route_generated = generate_pretty_url_pattern($url);

                            array_push($routing_urls, $route_generated);
                            if ($_POST['all'] == 'generateall') {
                                $findSlash = $route_generated['url'][(strlen($route_generated['url'])) - 3];

                                if ($findSlash == '/') {
                                    $proc_url['url'] = str_replace('/$@', '$@', $route_generated['url']);
                                } else {
                                    $proc_url['url'] = str_replace('$@', '/$@', $route_generated['url']);
                                }
                                $proc_url['controller'] = $route_generated['controller'];
                                $proc_url['view'] = $route_generated['view'];
                                array_push($routing_urls, $proc_url);
                            }

                        }
                    }

                    if (isset($rw)) {
                        // if overwrite is not set do not check for duplicate routes
                    } else {

                        foreach ($routing_urls as $route_url => $route) {
                            foreach ($_SERVER['scROUTES'] as $test) {
                                if ($test['url'] == $routing_urls[$route_url]['url']) {
                                    $match_urls[] = $routing_urls[$route_url];
                                    $routing_urls[$route_url] = '';
                                    $match++;
                                    break;
                                }
                            }
                        }

                    }
                    $routing_urls = ArrayRemoveEmpty($routing_urls);

                    $num_of_routes = 0;
                    if (isset($rw)) {
                        if (empty_routes()) {
                            foreach ($routing_urls as $route_url) {
                                add_to_routes($route_url);
                                $num_of_routes++;
                            }
                            $ALERTS->flashStrictNotice('New routing table generated. ' . $num_of_routes .
                                ' routes successfully added.');
                            admin_redirect_to('', 'routes');
                        }
                    } else {
                        if (count($routing_urls) > 0) {
                            //    print_r($match_urls);
                            foreach ($routing_urls as $route_url) {
                                add_to_routes($route_url);
                                $num_of_routes++;
                            }
                            $msg = $num_of_routes . ' routes successfully apended to routes.';
                            if (count($match_urls) > 0):
                                $msg .= ' Could not add ' . count($match_urls) .
                                    ' routes. Please select what you would like to do with them.';
                                $ALERTS->flashStrictNotice($msg);
                            else:
                                $ALERTS->flashStrictNotice($msg);
                                admin_redirect_to('', 'routes');
                            endif;
                            }
                            if (count($match_urls) > 0) {
                                $msg .= ' Could not add ' . count($match_urls) . ' routes.';
                                $ALERTS->flashStrictNotice($msg);

                                $route_counter = 0;
                                $route_counter++;
                                $_POST['gr'] = true;
                                $confirm_form .= "<form method=\"POST\" action=\"#\">";
                                $confirm_form .= '<table width="95%" border="0">
    <tr  bgcolor="#b7c2f7">
    <td></td><td width="16%"><b>Controller</b></td><td><b>View</b></td><td width="45%"><b>Generated Url</b></td><td width="25%"  bgcolor="#fff"></td>
    </tr>
    ';
                                foreach ($match_urls as $match_url => $route):
                                    $confirm_form .= "<tr id=\"route_" . ($match_url) . "\">
    ";
                                    $confirm_form .= "<td>" . ($match_url + 1) . "</td>
    ";
                                    $confirm_form .= "<td id=\"" . $match_url . "_controller\">$route[controller]</td>
    ";
                                    $confirm_form .= "<td><input id=\"" . $match_url . "_view\" type=\"text\" name=\"op_r" .
                                        $match_url . "[view]\" value=\"$route[view]\"></td>
    ";
                                    $confirm_form .= "<td><input id=\"" . $match_url . "_view\" size=\"50\" type=\"text\" name=\"op_r" .
                                        $match_url . "[url]\" value=\"" . htmlentities(ltrim(rtrim(
                                        $route['url'], '$@'),
                                        '@^')) . "\" /></td>
    ";
                                    $confirm_form .= "<td> 
     <span class=\"action\"><img onclick=\"deleteRouteEntry('route_" . ($match_url) .
                                        "');\" src=\"public/css/img/error.png\" class=\"action_d\" alt=\"Discard\" title=\"Discard now\" /> &nbsp;&nbsp; 
     <!--<img onclick=\"saveRouteEntry('route_" . ($match_url) . "')\" src=\"public/css/img/yes.png\" class=\"action_s\" alt=\"Overwrite route.\" title=\"Save Now\" />-->
     </span>    
     </td>
    ";
                                    $confirm_form .= "</tr>";
                                endforeach;
                                $confirm_form .= '
     </table>';
                                $confirm_form .= "<input type=\"hidden\" name=\"con\" value=\"$route[controller]\" />";
                                $confirm_form .= "<br />
     <input type=\"submit\" name=\"or\" value=\"Overwrite Routes\" /> 
     ";
                                $confirm_form .= "
     </form>
     <style>
     .action_d, .action_s{
        opacity:0.6;
     }
     
     .action_d:hover,.action_s:hover{
        opacity:1;
        cursor:pointer;
     }
     </style>
 ";
                            }
                        }
                    }
                } else {
                    flash_strict_warning('No such class found in the controller file. Class: ' . $_POST['controller']);
                }
            } else {
                flash_strict_warning("Could no locatate  controller file :" . '../' .
                    CONTROLLER_PATH . $_POST['controller'] . '.Controller.php');
            }

        }
    }


    //Processing conflicting routes form
    if (check_post_get('p', 'or')) {
        $_POST['or'] = '';
        $en_route['controller'] = $_POST['con'];
        $_POST['_controller'] = '';
        $list_of_routes = array();
        $routes = ArrayRemoveEmptyOrder($_POST);
        foreach ($routes as $route) {
            $en_route['view'] = $route['view'];
            $gen_route = generate_pretty_url_pattern($route['url']);
            $en_route['url'] = $gen_route['url'];
            array_push($list_of_routes, $en_route);
        }

        foreach ($list_of_routes as $route_url => $route) {

            foreach ($_SERVER['scROUTES'] as $test => $r) {
                if ($r['url'] == $route['url']) {
                    $_SERVER['scROUTES'][$test] = '';
                    $_SERVER['scROUTES'] = ArrayRemoveEmpty($_SERVER['scROUTES']);
                    array_push($_SERVER['scROUTES'], $route);
                }
            }
        }
        if (empty_routes()) {
            
            foreach ($_SERVER['scROUTES'] as $route_url) {
                add_to_routes($route_url);
            }
            flash_strict_notice('Routing table generated. ' . count($list_of_routes) .
                ' routes successfully overwritten.');
            admin_redirect_to('', 'routes');
        }
    }
