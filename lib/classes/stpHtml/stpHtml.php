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
 *
 * This file is the default application html class file.
 * it is still currently still under development.
 *
 * PHP versions 4 and 5
 */


#doc
#    classname:    stpHtml
#    scope:        PUBLIC
#
#/doc


class stpHtml
{


    var $tag;
    protected $attributes = array();
    var $singleTags = array('img', 'br', 'meta', 'link', 'input');
    var $noDisplay;
    public static $attr_sep;
    var $scripts = array('javascript', 'php', 'vbscript', 'xml');
    var $link_rel = array('stylesheet', 'appendix', 'alternate', 'bookmark',
        'chapter', 'contents', 'copyright','css');
    var $routeState;
    var $attrSep = ',';
    var $ROUTES;
    var $default = array('controller', 'page');
    var $url_array = array();
    var $page_title;
    var $meta;
    var $meta_array = array();
    var $sep;
    var $css;
    var $css_array = array();
    var $js_array = array();
    var $html5status;
    var $header_scripts = array();


    function __construct()
    {
        self::$attr_sep = '|'; //should be same as exploe demlimiter oTag() ln 111
        $this->sep = '|';
        $this->routeState = $_SERVER['scRouteConfig'];
        $this->ROUTES = $_SERVER['scROUTES'];
        $this->default['controller'] = $_SERVER['DEFAULT_CONTROLLER'];
        $this->default['page'] = $_SERVER['DEFAULT_PAGE'];

    }


    //Private functions
    private function display()
    {
        if (isset($this->display) && trim($this->noDisplay) != '') {
            return $this->tag;
        } else {
            echo $this->tag;
        }
    }

    public function script($type, $source = null, $script_code = null,$attributes = null, $no_display = null)
    {
        $this->comment($type.' code');
        if ((trim($source) != '') && (!preg_match('/src/', "$attributes"))) {
            $attributes .= $this->sep.'src,' . $source . $this->sep;
        }
        if(trim($script_code) == ''){
            $script_code = '';
        }else{
            $script_code = '
'.$script_code;
        }
        $this->autoConstructTags('script', $script_code,'type,text/' . $type.'| '.$attributes, $no_display);
        $this->comment($type.' code ends here');
    }


    function use_javascript($source = null,$attributes = null)
    {

        $this->script('javascript',$source,$attributes);
    }
    
    function use_js($source = null,$attributes = null)
    {

        $this->use_javascript($source,$attributes);
    }

    function style($style_code = null,$attributes = null,$noDisplay= null){

        if(trim($style_code) == ''){
            $style_code = '';
        }else{
            $style_code = '
'.$style_code;
        }

        $this->autoConstructTags('style',$style_code,$attributes,$noDisplay);

    }


    public function use_css($attributes = null)
    {
        $this->autoConstructTags('link', '','rel,stylesheet | type,text/css |'.$attributes);
    }


//echos out
    function output($text = null, $attributes = null)
    {
        echo $text;
    }


    /**
     * stpHtml::setAttributes()
     *
     * @param array $attributes
     * @return
     */
    private function setAttributes($attributes, $non_attributed)
    {
        $this->attributes = array_merge($this->attributes, $attributes);
        $this->attributes = array_merge($this->attributes, $non_attributed);
        $this->attributes = stpArrayRemoveEmpty($this->attributes);

        foreach ($this->attributes as $attribute => $value) {
            //setting attriutes properties and values
            if (is_int($attribute)) {
                if (isset($attribute) && trim($attribute) != ''):
                    $this->tag .= "" . $value . "";
                endif;
            } else {
                if (isset($attribute) && trim($attribute) != ''):
                    $this->tag .= " " . $attribute . '="' . str_replace(')', '\')', (str_replace('(',
                 //       '(\'', str_replace('%', '\',\'', str_replace('\'', '', str_replace('"', '', trim
                   //     ($value))))))) . '" ';
                            '(\'', str_replace('%', ',', str_replace('\'', '', str_replace('"', '', trim
                        ($value))))))) . '" ';
                endif;
            }
        }

    }


    //public

    function set_title($title = null)
    {
        if(isset($title) && trim ($title)!= null){
            $this->page_title = $title;
        }else{
            $this->page_title = APP;
        }
       // return $this->page_title;
    }

    function title($noDisplay = null){
       $this->autoConstructTags('title',$this->page_title,'',$noDisplay);

    }

    function meta($attributes,$noDisplay = null){

       $this->oTag('meta',$attributes,$noDisplay);

    }



/**
 * head constructor
 * constructs head tag
 */
public function set_head($attributes = null,$noDisplay = null)
{
$this->oTag('head',$attributes);

//adding preset meta tags
if(count($this->meta_array > 0)):
foreach($this->meta_array as $meta): $this->meta($meta) ;endforeach;
endif;

//setting up title
$this->oTag('title');
echo $this->page_title;
$this->cTag('title');

//adding preset css
if(count($this->css_array > 0)):
foreach($this->css_array as $css): $this->use_css('href,'."$css") ;endforeach;
endif;

//adding preset javascripts
if(count($this->js_array > 0)):
foreach($this->js_array as $js): $this->use_javascript('src,'."$js") ;endforeach;
endif;

$this->add_html5_functionality();
//closing head tag
$this->cTag('head');

}



    function add_meta($meta = null, $noDisplay = null)
    {
        if (isset($meta) && $meta != null) {
         array_push($this->meta_array,$meta.$this->sep);
        }

    }

     function add_css($path_to_css = null, $attributes = null)
    {
        if (isset($path_to_css) && $path_to_css != null) {
         array_push($this->css_array,$path_to_css.$this->sep);
        }

    }

     function add_js($path_to_js = null, $attributes = null)
    {
        if (isset($path_to_js) && $path_to_js != null) {
         array_push($this->js_array,$path_to_js.$this->sep);
        }

    }

    function add_html5_functionality(){
        if($this->html5status == true){
            $this->comment(	'[if IE]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]');
        }
    }

    /**
     * stpHtml::autoConstructTags()
     *
     * @param string $tag
     * @param string $atrributes eg. attr1,value1,value2
     * @param string $label
     * @return
     */
    public function autoConstructTags($tag, $label, $atrributes = null, $no_display = null)
    {

        $this->oTag($tag, $atrributes, $no_display);

        if (isset($label)) {
            if (!in_array(trim($tag), $this->singleTags)) {
                echo $label;
                $this->cTag($tag, $no_display);
            }
        }
    }

    /**
     * stpHtml::unSetAttributes()
     *
     * @return
     */
    private function unSetAttributes()
    {
        $this->attributes = array('id' => '', 'class' => '', 'href' => '');
    }


    /**
     * stpHtml::oTag()
     *
     * @param string $tag
     * @param string $attributes
     * @return
     */
    function oTag($tag, $attributes = null, $no_display = null)
    {
        $this->noDisplay = $no_display;
        $non_attributed = array();
        if (trim($tag) != '') {
$this->tag = "<" . strtolower($tag);

            if (isset($attributes) && trim($attributes) != '') {

                if (!is_string($attributes)) {
                    echo "<p>Atrributes should be of the format \"attr1,value1 | attr2,value2\" separated with |. Tag:$tag</p>";
                } else {
                    $attr_array = array();

                    $attributes = explode('' . self::$attr_sep . '', $attributes);
                    $attributes = stpArrayRemoveEmptyOrder($attributes);

                    foreach ($attributes as $attribute) {

                        if (preg_match("/$this->attrSep/", $attribute)) {
                            $attribute = explode($this->attrSep, $attribute);
                            $attribute = array_unique($attribute);
                            stpArrayRemoveEmptyOrder($attribute);

                            $attr = trim(array_shift($attribute));
                            if ($attr != 'style') {
                                if (count($attribute) <= 1) {
                                    $attr_array[$attr] = $attribute[0];

                                } else {

                                    echo $attr . ' cannot have more than one property.(' . count($attribute) . ')';
                                }
                            } else {

                                for ($i = 0; $i < count($attribute); $i++) {
                                    $value .= $attribute[$i];
                                }
                                $attr_array[$attr] = $value;
                            }
                        } else {
                            // echo "Attr sep not found!! $attribute";
                            array_push($non_attributed, $attribute);
                            $non_attributed = stpArrayRemoveEmptyOrder($non_attributed);
                        }
                    }

                    array_unique($attr_array);
                    $this->setAttributes($attr_array, $non_attributed);
                }
            }
            if (in_array(trim($tag), $this->singleTags)) {
$this->tag .= " />
";
            } else {
                // "Nope it needs a closing tag. Consider using \$this->cTag from stpHtml class or close it manually";
$this->tag .= ">
";
            }
        }
        $this->unSetAttributes();
        $this->display();
    }


    /**
     * stpHtml::cTag()
     *
     * @param mixed $tag
     * @return
     */
    function cTag($tag, $no_display = null)
    {
        $this->noDisplay = $no_display;
        $this->tag = "
</" . strtolower($tag) . ">
";
        $this->display();
    }


    //predefined task functions

    //link
    /**
     * stpHtml::a()
     *
     * @param string $label
     * @param mixed $reference
     * @param mixed $attributes
     * @return
     */
    function a($label = null, $reference = null, $attributes = null, $pretty = null,
        $no_display = null)
    {

        if (trim($label) == '') {
            $label = "link";
        }
        if ((trim($reference) == '') && (!preg_match('/href/', "$attributes"))) {
            $reference = "#";
            $attributes .= '|href,' . $reference . '|';
        } else {
            $attributes .= '|href,' . $this->alternative_link($reference, $pretty) . '|';
        }

        $this->autoConstructTags('a', $label, $attributes, $no_display);

    }


    /**
     * stpHtml::oDiv()
     *
     * @param mixed $type
     * @param mixed $attributes
     * @return
     */
    function oDiv($attributes = null, $no_display = null)
    {
        $this->oTag('div', $attributes, $no_display);
    }

    /**
     * stpHtml::cDiv()
     *
     * @return
     */
    function cDiv($no_display = null)
    {
        $this->cTag('div', $no_display);
    }

     function div($label = null,$attributes = null, $no_display = null)
    {
        $this->autoConstructTags('div', $label,$attributes, $no_display);
    }


     /**
     * stpHtml::oSpiv()
     *
     * @param mixed $type
     * @param mixed $attributes
     * @return
     */
    function oSpan($attributes = null, $no_display = null)
    {
        $this->oTag('span', $attributes, $no_display);
    }

    /**
     * stpHtml::cSpan()
     *
     * @return
     */
    function cSpan($no_display = null)
    {
        $this->cTag('span', $no_display);
    }

    function span($label = null,$attributes = null, $no_display = null)
    {
        $this->autoConstructTags('span', $label,$attributes, $no_display);
    }

    /**
     * stpHtml::img()
     *
     * @param mixed $src
     * @param mixed $attributes
     * @return
     */
    function img($src, $alt = null, $attributes = null, $no_display = null)
    {
        if ((trim($alt) == '') && (!preg_match('/alt/', "$attributes"))) {
            $alt = "";
            $alt .= '|alt,' . $alt . '|';
        } else {
            $attributes .= '|alt,' . $alt . '|';
        }

        if ((trim($src) == '') && (!preg_match('/src/', "$attributes"))) {
            $src = "#";
            $attributes .= '|src,' . $src . '|';
        } else {
            $attributes .= '|src,' . $src . '|';
        }

        $this->autoConstructTags('img', '', $attributes, $no_display);
    }

    /**
     * stpHtml::xhtml_state()
     *
     * @return
     */
    function xhtml_state($no_display = null)
    {
$xhtml_state = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
';
        if (isset($no_display) && trim($no_display) != '') {
            return $xhtml_state;
        } else {
            echo $xhtml_state;
        }
    }

    /**
     * stpHtml::xhtml_begin()
     *
     * @return
     */
    function xhtml_begin($attributes = null,$no_display = null)
    {
    $attributes = "xmlns=http://www.w3.org/1999/xhtml | ".$attributes;

    $this->oTag('html',$attributes);
    }

    /**
     * stpHtml::html5_state()
     * @abstract gives w3c html templating
     * @author skipper
     * @return
     */
    function html5_state($no_display = null)
    {
$html5 = '<!DOCTYPE html>
';
        if (isset($no_display) && trim($no_display) != '') {
            return $html5;
        } else {
            echo $html5;
            $this->html5status = true;
        }

    }

    /**
     * stpHtml::html5_begin()
     * @author skipper
     * @return
     */
    function html5_begin($attributes = null, $no_display = null)
    {
        $this->oTag('html',$attributes, $no_display);
    }

    /**
     * stpHtml::html_begin()
     *
     * @return
     */
    function html_begin()
    {
         $this->oTag('html',$attributes, $no_display);
    }


    /**
     * stpHtml::comment()
     *
     * @param string $string
     * @abstract comments html;
     * @author skipper
     * @return
     */
    function comment($string)
    {
echo "
<!--$string-->
";
    }


    function show($msg = null)
    {
        if (isset($msg) && ($msg) != '')
            echo $msg;
    }

    //Headers

    /**
     * stpHtml::h1()
     *
     * @param mixed $message
     * @param mixed $attributes
     * @return
     */
    function h1($message = null, $attributes = null, $no_display = null)
    {
        $this->h('1', $message, $attributes, $no_display = null);
    }

    /**
     * stpHtml::h2()
     *
     * @param mixed $message
     * @param mixed $attributes
     * @return
     */
    function h2($message = null, $attributes = null, $no_display = null)
    {
        $this->h('2', $message, $attributes, $no_display);
    }

    /**
     * stpHtml::h3()
     *
     * @param mixed $message
     * @param mixed $attributes
     * @return
     */
    function h3($message = null, $attributes = null, $no_display = null)
    {
        $this->h('3', $message, $attributes, $no_display);
    }

    /**
     * stpHtml::h4()
     *
     * @param mixed $message
     * @param mixed $attributes
     * @return
     */
    function h4($message = null, $attributes = null, $no_display = null)
    {
        $this->h('4', $message, $attributes, $no_display);
    }

    /**
     * stpHtml::h5()
     *
     * @param mixed $message
     * @param mixed $attributes
     * @return
     */
    function h5($message = null, $attributes = null, $no_display = null)
    {
        $this->h('5', $message, $attributes, $no_display);
    }

    /**
     * stpHtml::h6()
     *
     * @param mixed $message
     * @param mixed $attributes
     * @return
     */
    function h6($message = null, $attributes = null, $no_display = null)
    {
        $this->h('6', $message, $attributes, $no_display);
    }

    /**
     * stpHtml::h()
     *
     * @param int $header
     * @param string $message
     * @param mixed $attributes
     * @return
     */
    private function h($header, $message = null, $attributes = null, $no_display = null)
    {
        if (trim($message) == '') {

        }
        $this->autoConstructTags('h' . $header, $message, $attributes, $no_display );
    }


    /**
     * stpHtml::h()
     *
     * @param int $header
     * @param string $message
     * @param mixed $attributes
     */

    function p($message = null, $attributes = null, $no_display = null)
    {
        if (!isset($message)) {
            $message = '&nbsp';
        }
        $this->autoConstructTags('p', $message, $attributes, $no_display);
    }


    //formatting functions
    function b($message = null, $attributes = null, $no_display = null)
    {
        if (!isset($message)) {
            $message = '&nbsp';
        }
        $this->autoConstructTags('b', $message, $attributes, $no_display);
    }


    //table functions
    function tr($message = null, $attributes = null, $no_display = null)
    {
        if (!isset($message)) {
            $message = '&nbsp';
        }
        $this->autoConstructTags('tr', $message, $attributes, $no_display);
    }

    //table functions
    function td($message = null, $attributes = null, $no_display = null)
    {
        if (!isset($message)) {
            $message = '&nbsp';
        }
        $this->autoConstructTags('td', $message, $attributes, $no_display);
    }


    //list functions
    /**
     *@description takes a value and puts in ul lists
     *@param array $list_elements
     *@param string $ul_attributes - in the stphtml attribute string form
     *@param string $li_attributes - in the stphtml attribute string form
     */
    function ul($list_elements = null, $ul_attributes = null, $li_attributes = null,
        $list_type = null, $no_display = null)
    {

        $this->oTag('ul', $ul_attributes);
        if (is_array($list_elements)) {
            foreach ($list_elements as $list => $value):

                if (is_array($list_elements[$list])) {
                    $this->ul($list_elements[$list], $ul_attributes, $li_attributes, $list_type);
                } else {
                    if (trim($list_type) != '') {
                        $this->$list_type($value, $li_attributes);
                    } else {
                        $this->li($value, $li_attributes);
                    }
                }
            endforeach;
        } else {
            if (trim($list_elements) != '') {
                echo $list_elements;
                if (trim($list_type) != '') {
                    $this->$list_type($list_elements, $li_attributes);
                } else {
                    $this->li($list_elements, $li_attributes);
                }
            }
        }
        $this->cTag('ul');
    }


    function li($message = null, $attributes = null, $no_display = null)
    {
        if (!isset($message)) {
            $message = '&nbsp';
        }
        $this->autoConstructTags('li', $message, $attributes);
    }


    function ol($message = null, $attributes = null)
    {
        if (!isset($message)) {
            $message = '&nbsp';
        }
        $this->autoConstructTags('ol', $message, $attributes);
    }


    function br($attributes = null, $no_display = null)
    {
        $this->oTag('br', $attributes, $no_display);
    }


    /**
     * Proccess functions
     *
     */

    //Auto converts urls to alternative pretty url
    private function alternative_link($url, $strict = null)
    {
        if ($this->routeState == 'On') {

            if (preg_match('/[?]/', $url)) {
                if (isset($this->ROUTES)) {
                    $url_collected[0] = array();
                    $control = array();

                    // Removes Apllication index from url
                    $url = str_replace('index.php', '', $url);
                    $url = str_replace('index.html', '', $url);
                    $url = str_replace('index.htm', '', $url);

                    //seperate query string and values
                    $exploded_url = explode('&', $url);

                    //seperate variables and values so they can be mapped in an array
                    foreach ($exploded_url as $tr_url) {
                        if ($valued_gets = explode('=', ltrim($tr_url, '?'))) {
                            if (count($valued_gets) <= 1):
                                $trail_slash = true;
                            endif;
                        }

                        //get values mapping
                        if (!filter_var($valued_gets[0], FILTER_VALIDATE_URL)) {
                            $control[$valued_gets[0]] = $valued_gets[1];
                            //  echo $valued_gets[0].' - '.$valued_gets[1].'<br />';
                            //  if(($control['controller'])== ''): $control['controller']= APP; endif;
                            $control['on'] = true;
                        } else {
                            return $valued_gets[0];
                        }
                    }
                    //print_r($control);
                    if ($control['on'] == true) {

                        //Create a route to atuo add to the routing table
                        $url_collected[0]['url'] = '/^';
                        foreach ($control as $key => $value):
                            if ($key != 'on'):
                                if ($key != 'controller' && $key != 'page') {
                                    $url_collected[0]['url'] .= '(?P<' . $key . '>[A-Za-z0-9-]+\w+)\\/';
                                }

                            endif;
                        endforeach;
                        $url_collected[0]['url'] .= '$/';

                        $url_collected[0]['controller'] = $control['controller'];
                        $url_collected[0]['view'] = urlencode($control['view']);
                        $_SERVER['scROUTES'] = array_merge($_SERVER['scROUTES'], $url_collected);

                        foreach ($control as $key => $value):
                            if ($key != 'on'):
                                $pretty_url .= $value . '/';
                            endif;
                        endforeach;
                    }
                    //  if(!$trail_slash):$pretty_url = '/'.$pretty_url;endif;
                    if (preg_match("/^[http:]/", WEB_URL)) {
                        $pretty_url = WEB_URL . $pretty_url;
                    }

                    return $pretty_url;
                } else {
                    return $url;
                }
            } else {
                return $url;
            }
        } else {
            return $url;
        }
    }
/*
    protected function addUrlPatern($url_patern)
    {
        array_push($url_patern, $this->url_array);
        //    print_r($this->url_array);
    }
    protected function url_merger($url)
    {

    }
*/
}
