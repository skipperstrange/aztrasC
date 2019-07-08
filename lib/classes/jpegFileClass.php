<?php

require_once 'fileSystemClass.php';

class jpegFileClass extends FileSystem{

    static $canvas_width;
    static $canvas_height;
    static $canvas;
    static $image_info;
    static $x_start;
    static $y_start;


    /**
     *@param $image - source image
     *@param $destination_image - final output image
     *@param $canvas_width - desired canvas width
     *@param $canvas_height - desired canvas height
     *@param $width_scale - width scale
     *@param $height_scale - height scale
     *@param $x_start - image x scale start
     *@param $y_start - image y scale start
     *@param $quality - quality of output image
     *
     *@author Skipper Strange <skipperstrange@gmail.com>
     */

    function scale_image($image,
                         $destination_image,
                         $canvas_width,
                         $canvas_height,
                         $width_scale = null,
                         $heigt_scale = null,
                         $x_start = null,
                         $y_start = null,
                         $quality = null){

        //setting canvas dimensions for new image
        self::set_canvas_dimensions($canvas_width, $canvas_height);

        //creating canvas
        $canvas = imagecreatetruecolor($canvas_width,$canvas_height);
        //getting image info
        self::$image_info = self::get_image_info($image);
        //load image
        $loaded_image = imagecreatefromjpeg($image);

        //generating image
        imagecopyresampled($canvas, $loaded_image, 0, 0, $x_start, $y_start, $width_scale, $heigt_scale, self::$image_info['width'], self::$image_info['height']);

        //setting quality
        if(!isset($quality)):$quality = 99; endif;
        if(imagejpeg($canvas, $destination_image,$quality)){
            return true;
        }else{
            return false;
        }


    }

    function thumb_nail($image,$destination_image,$quality = null){
            self::set_image_info($image);
            self::scale_image( $image, $destination_image, 75, 75, 75, 75, $image_info['width']/2, $image_info['height']/2, 80);
    }

    /**
     *
     *@param $image - source image
     *@param $destination_image - final output image
     *@param $canvas_scale -  scale
     *@param $x_start - image x scale start
     *@param $y_start - image y scale start
     *@param $quality - quality of output image
     *
     *@author Skipper Strange <skipperstrange@gmail.com>
     */
    function auto_scale_image(
                              $image,
                              $destination_image,
                              $canvas_scale,
                              $base = null,
                              $x_start = null,
                              $y_start = null,
                              $quality = null){

                $canvas = self::auto_resize($image, $canvas_scale, $base);
                if(self::scale_image($image,$destination_image, $canvas['width'], $canvas['height'], $canvas['width'], $canvas['height'], $x_start, $y_start,$quality)){
                    return true;
                }

    }

    static function auto_resize($image, $canvas_scale, $base_side_with_or_height = null){
            self::set_image_info($image);
            $ratio = self::$image_info['width']/self::$image_info['height'];

                if(isset($base_side_with_or_height) && trim($base_side_with_or_height) != ''){
                    $base_side_with_or_height = trim($base_side_with_or_height);
                    if($base_side_with_or_height === 'width'):
                    $canvas['width'] = $canvas_scale;
                    $canvas['height'] = ((self::$image_info['height']*$canvas['width'])/self::$image_info['width']);

                    endif;

                     if($base_side_with_or_height === 'height'):
                    $canvas['width'] = $canvas_scale;
                    $canvas['height'] = ((self::$image_info['height']*$canvas['width'])/self::$image_info['width']);
                    endif;
                }else{
                if($ratio > 1){
                    $canvas['width'] = $canvas_scale;
                    $canvas['height'] = ((self::$image_info['height']*$canvas['width'])/self::$image_info['width']);

                }elseif($ratio < 1){
                    $canvas['height'] = $canvas_scale;
                    $canvas['width'] = ((self::$image_info['width']*$canvas['height'])/self::$image_info['height']);
                }elseif($ratio === 1){
                        $canvas['width'] = $canvas_scale;
                        $canvas['height'] = $canvas_scale;
                    }
                }

                return $canvas;
    }



    static public function set_canvas_dimensions($canvas_width, $canvas_height){
        self::$canvas_width = $canvas_width;
        self::$canvas_height = $canvas_height;
    }

    static public function get_image_info($image){
        
        $dim = getimagesize($image);

        $dim['width'] = $dim[0];
        $dim['height'] = $dim[1];
        $dim['num'] = $dim[2];
        $dim = self::filterOutArrayIndexed($dim);

        return $dim;
    }
    
    static function get_width_height_ration($image){
        self::$image_info = self::get_image_info($image);
        return self::$image_info['width']/self::$image_info['height'];
    }
    
    static function get_height_width_ration($image){
        self::$image_info = self::get_image_info($image);
        return self::$image_info['height']/self::$image_info['width'];
    }

    static function set_image_info($image){
        self::$image_info = self::get_image_info($image);
    }



}