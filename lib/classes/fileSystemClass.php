<?php

/*
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
 */


#doc
#        classname:        FileSystem
#        scope:            PUBLIC
#
#
#/doc

class FileSystem
{

    private static $folderFileStucture = array();
    private static $folderStucture = array();
    private $error;
    public static $file_contents;
    public static $writModes = array('w', 'r', 'a', 'w+', 'r+', 'a+');

    #        Constructor
    function __construct()
    {
        # code...

    }
    ###

    public function setContent($content)
    {
        return self::$file_contents = $content;
    }


    private function displayError($error = null)
    {
        if (isset($error)):
            echo ($error);
        endif;
    }
    //return list of directoris in a given folder
    static function getDirectories($directory)
    {
        $directories = self::scanDirectory($directory);
        $dir = array();

        for ($i = 0; $i < count($directories); $i++) {
            if (!preg_match('/[\w]\.[a-z_0-9]{2,4}/', $directories[$i])) {
                array_push($dir, $directories[$i]);
            }
        }
        return $dir;
    }

    static function scanDirectory($directory, $error = null)
    {
        if ($directory[strlen($directory) - 1] == '/') {
            $directory = rtrim($directory, '/');
        }
        if (is_dir($directory)) {
            $directory_files = scandir($directory);
            //print_r($directory_files);
            array_shift($directory_files);
            array_shift($directory_files);
            return $directory_files;
        } else {
            if (isset($error) && ($error == 0)) {
                return false;
            } else {
                echo $error;
                self::displayError("<p> Could not find the directory $directory. Please make sure the directory exists.</p>");
            }

        }

    }

   static function max_valid_file_size($file_size, $max_size)
    {
        if ($file_size < $max_size && $file_size > 0) {
            return true;
        } else {
            return false;
        }
    }

    static function min_valid_file_size($file_size, $min_size)
    {
        if ($file_size > $min_size && $file_size > 0) {
            return true;
        } else {
            return false;
        }
    }

    static function file_extension($file_name)
    {
        if(is_dir($file_name)){
            echo 'Invalid file type. No folders';
        }else{
        if(!is_string($file_name)){
            echo 'Invalid file.';
        }else{
            return array_pop(explode('.',$file_name));
        }
        }
    }

    static function valid_file_extension($file,$extension)
    {
        if(self::file_extension($file) == $extension){
            return true;
        }else{
            return false;
        }
    }

    function folderStructure($directory, $mode = null, $full_srtucture = null)
    {

        if ($directory[strlen($directory) - 1] == '/') {
            $directory = rtrim($directory, '/');
        }
        //Setts directory as array to start recieving files
        self::$folderFileStucture[$directory] = array();
        //Getting files in directory
        if ($files = self::scanDirectory($directory)) {
            //Files got are checked
            foreach ($files as $file) {
                if (is_dir($directory . DS . $file)) { //if its a directory, its run throug this function again

                    array_push(self::$folderStucture, $directory);
                    self::folderStructure($directory . DS . $file, $mode, $full_srtucture);
                } else {
                    if (isset($full_srtucture) && trim($full_srtucture) != '') {
                        array_push(self::$folderFileStucture[$directory], $directory . DS . $file);
                    } else {
                        array_push(self::$folderFileStucture[$directory], $file);
                    }
                }
            }
        }

        foreach (self::$folderFileStucture as $folderSystem => $structure) {
            array_push(self::$folderStucture, $folderSystem);
        }

        if (isset($mode) && trim($mode) != '') {
            $f = arrayRemoveEmptyOrder(array_unique(self::$folderStucture));
            return $f;
        } else {
            $f = self::$folderFileStucture;
            return $f;
        }

    }


    //fetch all files in a named dir
    static function get_all_files($directory, $error = null)
    {

        $directory_files = self::scanDirectory($directory, $error);
        $files = array();
        for ($i = 0; $i < count($directory_files); $i++) {
            if (is_file($directory . $directory_files[$i])) {
                array_push($files, $directory_files[$i]);
            }
        }
        return $files;

    }


    function copyFolderStructure($source_folder, $destination_folder)
    {
        $i = 0;
        foreach (self::folderStructure($source_folder, 1) as $dir) {
            if (@!mkdir(str_replace($source_folder, $destination_folder, $dir))) {
                $i++;
            }

        }
        if ($i > 0) {
            return false;
        } else {
            return true;
        }
    }


    function copyFolder($source, $destination)
    {
        self::copyFolderStructure($source, $destination);
        $app = self::folderStructure($source);
        foreach (self::folderStructure($source) as $dir => $file) {
            foreach ($app[$dir] as $files):
                copy($dir . DS . $files, str_replace($source, $destination, $dir) . DS .
                    str_replace($source, $destination, $files));
            endforeach;
        }
    }

    function deleteFile($source)
    {
        for ($i = 0; $i < 10; $i++):
            if (!is_dir($source)) {
                @unlink($source);
            } else {
                $app = self::folderStructure($source);
                foreach ($app as $dir => $file) {
                    foreach ($app[$dir] as $files):
                        @unlink($dir . DS . $files);
                    endforeach;
                    @rmdir($dir);
                }
                @rmdir($source);
            }

        endfor;
        if (file_exists($source)) {
            return false;
        } else {
            return true;
        }
    }

    function createFile($filename = null, $filePath = null, $contents = null, $force_create = null,
        $apend_mode = null, $error = null)
    {

        $e = 0;
        if (!in_array($apend_mode, self::$writModes)):
            $apend_mode = 'r+';
        endif;
        if (isset($filePath) && trim($filePath) != null):
            if ($filePath[strlen($filePath) - 1] == DIRECTORY_SEPARATOR) {
                $filePath = rtrim($filePath, DIRECTORY_SEPARATOR);
                $filePath .= DIRECTORY_SEPARATOR;
                if (!is_dir($filePath)) {
                    if (!mkdir($filePath)) {
                        $e++;
                        $msg .= "<p>Could not create Folder</p>";
                    }
                }
            }
        endif;

        if ($e == 0):
            if (isset($filename) && trim($filename) != null):
                if (!$create_file = touch($filePath . $filename)) {
                    $msg .= "<p>Could not create " . $filePath . $filename . "</p>";
                    $e++;
                } else {
                    if (isset($contents) && trim($contents) != null) {
                        $handle = fopen($filePath . $filename, $apend_mode);
                        if (fwrite($handle, stripslashes_deep($contents))) {
                            fclose($handle);
                            return true;
                        } else {
                            $msg .= ' Could not put contents to file:';
                        }
                    }
                }
            endif;
        endif;
        if (isset($error) && trim($error) != ''):
            self::displayError($msg);
        endif;
    }

    //reads file contents (txt type files only)
     function getFileContents($file)
    {
        $content = array();

        if ($open_file = @fopen($file, 'r')) {
            while (!feof($open_file)) {
                if ($entry = trim(fgets($open_file))) {
                    array_push($content, $entry);
                }
            }
            return $content;
        }
        else{
            echo "<p> File - Could not open $file. No such file exists</p>";
        }
    }




    //Array Functions
//takes an array and removes all empty value keys
/**
 *@abstract function that removes all empty keys in an array
 *@author skipper
 *@param array
 */
function ArrayRemoveEmpty($arr)
{
    $arr = array_filter($arr);
    return $arr;
}


//takes an array and removes all empty value keys
/**
 *@abstract function that removes all empty keys in an array and returns them in order
 * keys will be replaced by indexed keys
 *@author skipper
 *@param array
 */
function ArrayRemoveEmptyOrder($arr)
{

    $arr = array_filter($arr);

    $newMy = array();
    $i = 0;

    foreach ($arr as $key => $value) {
        if (!is_null($value)) {
            $newMy[$i] = $value;
            $i++;
        }
    }
    return $newMy;
}

/** Array functions
 */

function setArrayKeyEqualValue($array)
{
    $new_array = array();
    foreach ($array as $arr => $value) {
        $new_array[$value] = $value;
    }
    return $new_array;
}


function setArrayValueEqualKey($array)
{
    $new_array = array();
    foreach ($array as $arr => $value) {
        $new_array[$arr] = $arr;
    }
    return $new_array;
}


//Filter index and values


function filterOutArrayIndexed($array)
{
    $filtered_array = array();
    if (is_array($array)) {
        foreach ($array as $arr => $value) {
            if (!is_int($arr)) {
                $filtered_array[$arr] = $value;
            }
        }
        return $filtered_array;
    } else {
        return false;
    }

}

function filterOutArrayNonIndexed($array)
{
    $filtered_array = array();
    foreach ($array as $arr => $value) {

        if (is_int($arr)) {
            $filtered_array[$arr] = $value;
        }
    }
    return $filtered_array;
}

}
