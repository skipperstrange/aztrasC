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
#        classname:        phpFileSystem
#        scope:            PUBLIC
#        
#
#/doc


class PhpFileSys extends FileSystem{
	
    
    
   	static function require_all_files_once($directory)
	{
		$directory_files = self::get_all_files($directory);
		if($directory_files) {
			foreach($directory_files as $file) {			 
				require_once "$directory$file";
			}

		}
	}


static function require_all_files($directory)
	{
		$directory_files = self::get_all_files($directory);
		if($directory_files) {
			foreach($directory_files as $file) {			 
				require_once "$directory$file";
			}

		}
	}

	/**
	 * include_all_dir_files_once()
	 * 
	 * @param mixed directory
	 * @return void
	 * @author skipper
	 * Includes all files in a directory
	 */
	static function include_all_files_once($directory)
	{
		$directory_files = self::get_all_files($directory);
		if($directory_files) {
			foreach($directory_files as $file) {
				include_once "$directory$file";
			}

		}
	}
      
    /**
	 * include_all_dir_files_once()
	 * 
	 * @param mixed directory
	 * @return void
	 * @author skipper
	 * Includes all files in a directory
	 */
	static function include_all_files($directory)
	{
		$directory_files = self::get_all_files($directory);
		if($directory_files) {
			foreach($directory_files as $file) {
				include "$directory$file";
                echo $directory.$file.'<br />';
			}

		}
	}
    
}