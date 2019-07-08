<?php

 $routes_file = UP_ONE . CONFIG_PATH . 'routes.php';

/**
 * This function relies on the state of the $_SERVER['scROUTES'] array
 * Adds a route to the routes table/array
 * @param array $routes
 * @return boolean
 * @author skipper
 */
function add_to_routes($route)
{
    $routes_file = UP_ONE . CONFIG_PATH . 'routes.php';
    //Check if route file exists
    if (file_exists($routes_file)) {
        include $routes_file;
        if (count($_SERVER['scROUTES']) == 0) {

            $content = '<?php
$_SERVER[\'scROUTES\'] = array(';

            $content .= '
//# controller:' . $route['controller'] . ' view:' . $route['view'] . '
array(';

            foreach ($route as $value => $v):
                if ($i < count($route) - 1) {
                    $content .= '\'' . $value . '\'=>\'' . $v . '\', ';
                    $i++;
                } else {
                    $content .= '\'' . $value . '\'=>\'' . $v . '\'';
                }
            endforeach;
            $content .= ')';
            $content .= '
);';

            if (@unlink($routes_file)) {
                if (!touch($routes_file)) {
                    return false;
                } else {
                    $handle = fopen($routes_file, 'w+');
                    if (fwrite($handle, $content)) {
                        fclose($handle);
                        return true;
                    }
                }
            }
        } else {
            array_push($_SERVER['scROUTES'], $route);

            $content = '<?php
$_SERVER[\'scROUTES\'] = array(';

            $j = 0;
            foreach ($_SERVER['scROUTES'] as $route) {
                $i = 0;
                $content .= '
//# controller:' . $route['controller'] . ' view:' . $route['view'] . '
array(';

                foreach ($route as $value => $v):
                    if ($i < count($route) - 1) {
                        $content .= '\'' . $value . '\'=>\'' . $v . '\', ';
                        $i++;
                    } else {
                        $content .= '\'' . $value . '\'=>\'' . $v . '\'';
                    }
                endforeach;

                $content .= '),
';
            }
            $j++;
            $content .= '
#end of routes
);

?>';

            if (@unlink($routes_file)) {
                if (!touch($routes_file)) {
                    return false;
                } else {
                    $handle = fopen($routes_file, 'w+');
                    if (fwrite($handle, $content)) {
                        fclose($handle);
                        return true;
                    }
                }
            }
        }
    } else {

        if (empty_routes()) {
            include $routes_file;
            array_push($_SERVER['scROUTES'], $route);

            $content = '<?php
$_SERVER[\'scROUTES\'] = array(';

            $j = 0;
            foreach ($_SERVER['scROUTES'] as $route) {
                $i = 0;
                $content .= '
//# controller:' . $route['controller'] . ' view:' . $route['view'] . '
array(';

                foreach ($route as $value => $v):
                    $content .= '\'' . $value . '\'=>\'' . $v . '\'';
                endforeach;

                $content .= ')
';
            }
            $content .= '
#end of routes
);

?>';
 
            if (unlink($routes_file)) {
                if (!touch($routes_file)) {
                    return false;
                } else {
                    $handle = fopen($routes_file, (int)'w+');
                    if (fwrite($handle, $content)) {
                        fclose($handle);
                        return true;
                    }
                }
            }
        }
    }
   
}

/**
 * Reset Routes
 * Resets The route file.
 */

function empty_routes()
{
    $content = '<?php
$_SERVER[\'scROUTES\'] = array()
?>';
    $routes_file = '../' . CONFIG_PATH . 'routes.php';
    if (file_exists($routes_file)) {
        if (@unlink($routes_file)) {
            if (!touch($routes_file)) {
                return false;
            } else {

                $handle = fopen($routes_file, 'w+');
                    if (fwrite($handle, $content)) {
                    fclose($handle);
                    return true;
                }
            }
        }
    } else {
        if (!touch($routes_file)) {
            return false;
        } else {
            $handle = fopen($routes_file, 'w+');
            if (fwrite($handle, $content)) {
                fclose($handle);
                return true;
            }
        }
    }

}


/**
 * This function generates pretty url pattern
 * Possibly brings back controller and view parameter
 * generat_pretty_url
 * @param string $url
 * @return array
 * @author skipper
 */
function generate_pretty_url_pattern($url)
{
    if (@preg_match('/^index.php/', $url) || @preg_match('/^index.php?/', $url) ||
        @preg_match('/^index.html/', $url) || @preg_match('/^index.html?/', $url) ||
        @preg_match('/^index.htm/', $url) || @preg_match('/^index.htm?/', $url) ||
        @preg_match('/^[?]/', $url)) {
        $url_collected = array();
        $control = array();

        // Removes Apllication index from url
        $url = str_replace('index.php', '', $url);
        $url = str_replace('index.html', '', $url);
        $url = str_replace('index.htm', '', $url);

        //seperate query string and values
        $exploded_url = explode('&', $url);

        $i = 0;
        foreach ($exploded_url as $tr_url) {
            if ($valued_getss[$i] = explode('=', ltrim($tr_url, '?'))) {
                $i++;
                if (count($valued_getss) <= 1):
                    $trail_slash = true;
                endif;
            }
        }

        //get values mapping
        foreach ($valued_getss as $valued_gets):
            if (!filter_var($valued_gets[0], FILTER_VALIDATE_URL)) {
                $control[$valued_gets[0]] = $valued_gets[1];
            }
        endforeach;

        //Creating  route pattern
        $url_collected['url'] = '@^';

        if ($control['view'] != $DEFAULT_VIEW) {
            $url_collected['url'].= $control['view'].'/';
        }

        foreach ($control as $key => $value):

            if ($key != 'controller' && $key != 'view') {
                $url_collected['url'] .= '(?P<' . urlencode($key) . ">\w+)/";
            }
            
        endforeach;

        $url_collected['url'] .= '$@';
        if (isset($control['controller']) && trim($control['controller']) != '') {
            $url_collected['controller'] = $control['controller'];
        }

        if (isset($control['view']) && trim($control['view']) != '') {
            $url_collected['view'] = $control['view'];
        }

    } else {
        $url_collected['url'] = '@^';
        $url = implode('-', ArrayRemoveEmpty(explode(' ', $url)));
        $url = str_replace('\/', '/', $url);

        $url = ltrim($url, '/');

        $url_array = explode('/', $url);

        $url_collected['url'] .= implode('/', $url_array);
        $url_collected['url'] .= '$@';
    }

    return $url_collected;

}

function delete_route($index)
{
   
    $_SERVER['scROUTES'][$index] = '';
    
    $_SERVER['scROUTES'] = ArrayRemoveEmptyOrder($_SERVER['scROUTES']);
  
    $rr = 0;
    if (empty_routes()) {
        foreach ($_SERVER['scROUTES'] as $reseted) {
            if (add_to_routes($reseted)) {
                $rr++;
            }
        }
    }
return true;
}


function routes_backup($file_path)
{
    $routes_file = UP_ONE . CONFIG_PATH . 'routes.php';
    //Check if route file exists
    if (file_exists($routes_file)) {
        if (!file_exists($file_path)) {
            return @copy($routes_file, $file_path);
        }else{
            return 2;
        }
    }
}

function routes_restore($file_path, $force = null)
{
    $routes_file = UP_ONE . CONFIG_PATH . 'routes.php';
    //Check if route file exists
    if (file_exists($routes_file)) {
        if (!file_exists($file_path)) {
            return @copy($file_path,$routes_file);
        }else{
            if(isset($force)){
                @unlink($routes_file);
                return @copy( $file_path,$routes_file);
            }else{
                  return 2;
            }

        }
    }
}


//Default routes
$ROUTES_RESET = array( #arrayed example
    //# controller:aztrasC view:index
array('url'=>'@^home$@', 'controller'=>APP, 'view'=>'index'),

//# controller:aztrasC view:index
array('url'=>'@^home/$@', 'controller'=>APP, 'view'=>'index'),

//# controller:aztrasC view:index
array('url'=>'@^$@', 'controller'=>APP, 'view'=>'index'),

//# controller:aztrasC view:index
array('url'=>'@^index/$@', 'controller'=>APP, 'view'=>'index'),

//# controller:aztrasC view:index
array('url'=>'@^index$@', 'controller'=>APP, 'view'=>'index'),

//# controller:aztrasC view:setup
array('url'=>'@^setup/$@', 'controller'=>APP, 'view'=>'setup'),

#end of routes
//Last route always routes to the default
array('url' => '@^$@', 'controller' => APP, 'view' => 'index'), );