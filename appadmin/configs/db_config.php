<?php


/**
 * Aztraz/ScoopMinimal - PHP MVC Framework libraries
 *
 * Copyright (C) 20011 Nana Yaw Duah A.K.A Skipper Strange <skipperstrange@gmail.com>
 *
 * Developers:
 *		Nana Yaw Duah A.K.A Skipper Strange <skipperstrange@gmail.com>
 *
 * Contributors:
 *
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the
 * GNU Lesser General Public License as published by the Free Software Foundation.
 *
 * Read the full licence: http://www.opensource.org/licenses/lgpl-license.php
 *
 * File: Databse Configurations handler
 */


        if ($_POST['submitDB']) {
            $db = $_POST['db_config'];
            $passCr = $_POST['db'];
            $arrPassCr = array();
            $err = 0;
            /**
             * Form validation
             */
             $validate = Validate::form_validate($db, 1, 2);
                $er = 0;
            if ($validate !== true) {
                    flash_warning($validate);
                    $er++;
                } else {
                foreach ($passCr as $p => $value):
                    if (trim($value) != ''):
                        $arrPassCr[$p] = $value;
                    endif;
                endforeach;

                if (count($arrPassCr) > 0):
                    if (Validate::form_validate($arrPassCr)):
                        $db = array_merge($db, $arrPassCr);
                    endif;
                endif;
            }

            /**
             * Testing db connection codes
             */
            if (isset($_POST['checkConnection']) && trim($_POST['checkConnection']) == 'on' && $er == 0) {
                if (@!mysql_connect($db['host'], $db['username'], $db['password'])) {
                    $dbmsg .= '*<b>Database connection could not be made. Please check your credentials.</b> Action: Test Connection<br />';
                    $err++;
                } else {
                    if (isset($db['database'])) {
                        if (isset($_POST['createdb']) && trim($_POST['createdb']) == 'on') {
                            if (!mysql_select_db($db['database'])) {
                                mysql_close();
                                $suc .= $db['database'] . ' does not exist.<br />';

                            } else {
                                $suc .= $db['database'] . ' exists on your Database server(Mysql).<br />';
                                mysql_close();
                            }
                        }
                    }
                }
            }

            /**
             * Create database option codes
             */
            if (isset($_POST['createdb']) && trim($_POST['createdb']) == 'on') {
                if (trim($db['database']) != '') {
                    if (@!mysql_connect($db['host'], $db['username'], $db['password'])) {
                        $dbmsg .= '*<b>Database connection could not be made. Please check your credentials.</b> Action: Create Database ('.$db['database'].')';
                        $err++;
                    } else {
                        if (!mysql_select_db($db['database'])) {
                            if (@mysql_query("CREATE DATABASE " . $db['database'])) {
                                mysql_close();
                                $suc .= $db['database'] . ' created.<br />';
                            }

                        } else {
                            mysql_close();
                        }
                    }
                } else {
                    $err++;
                    flash_strict_warning('Please provide a name for the database');
                }
            }

            if ($err > 0 || $er >0) {
                flash_strict_notice($dbmsg);
            } else {
$db['username'] = toAscii($db['username'],array('"',"'"),'_');
$db['host'] = toAscii($db['host']);
$db['password'] = toAscii($db['password'],array('"',"'"),'_');
$db['database]'] = toAscii($db['database'],array('"',"'"),'_');

$dbconfig = "<?php
define(USERNAME,'$db[username]') ;
define(HOST,'$db[host]') ;
define(PASSWORD,'$db[password]') ;
";

                if (isset($db['database']) && trim($db['database'])!=''):
                    $dbconfig .= "define(DATABASE,'".toAscii($db['database]'],array('"',"'"),'_')."') ;
";
                endif;

                if (FileSystem::createFile($db_file, '', $dbconfig)) {
                    $suc .= 'Database credentials saved.<br />';

                }
            }

            if (isset($suc) && trim($suc)) {
                flash_notice($suc);
                admin_redirect_to('', $view);
            }

        }

        if(trim($_GET['delete']) == true):
        if(file_exists($db_file)){
         if(trim($_GET['confirm']) == 'pr'){
              if(FileSystem::deleteFile($db_file)){
                flash_strict_warning("database configuration file has been deleted!");
                admin_redirect_to('',$admin_view);
              }else{
                flash_strict_warning("database configuration file could not be deleted!");
                admin_redirect_to('',$admin_view);
              }
         }else{
        $confirm = "Are you sure you want to delete your databse configuration?
        <a href=\"index.php?view=$admin_view&delete=$_GET[delete]&confirm=pr\">Proceed</a> |
        <a href=\"index.php?view=$admin_view\">Cancel</a>
        <br /><span class=\"desc\"> This action is irreversible but can be reconfigured</span>";
        $ALERTS->flashStrictWarning($confirm);
        }
    }else{
        flash_strict_warning("??... database configuration does not exist!");
        admin_redirect_to('',$admin_view);
    }
        endif;

        if(trim($_GET['clear']) == true):
         if(trim($_GET['confirm']) == 'pr'){
              if(FileSystem::deleteFile($db_file)){
                if(FileSystem::createFile($db_file)){
                flash_strict_warning("database configuration file has cleared!");
                admin_redirect_to('',$admin_view);
                }
         }
        }else{
        $confirm = "Are you sure you want to clear out your databse configuration?
        <a href=\"index.php?view=$admin_view&clear=$_GET[clear]&confirm=pr\">Proceed</a> |
        <a href=\"index.php?view=$admin_view\">Cancel</a>
        <br /><span class=\"desc\"> This action is irreversible but can be reconfigured</span>";
        $ALERTS->flashStrictWarning($confirm);
        }
        endif;
