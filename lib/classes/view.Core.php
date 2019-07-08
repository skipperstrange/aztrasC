<?php

class aztrasLoader
{

    public $view_file;
    public $controller;
    public $load_view;
    public $data;


    public function __construct($controller = null)
    {
        if (isset($controller) && trim($controller) != ''):
            $this->controller = strtolower($controller);
        endif;
    }

    function view($view_file = null, $data = null)
    {
        if(isset($data)): $this->data = $data; endif;
        
        if (is_array($this->data)) {
            extract($this->data);
        }
        
        if (isset($view_file) && trim($view_file) != ''):
            $this->view_file = $view_file;
            include (LIB_PATH . 'layout' . DS . 'header.php');

            if (file_exists(LIB_PATH . 'layout' . DS . 'default.php')) {
                require (LIB_PATH . 'layout' . DS . 'default.php');

            } else {
                if (require_once (LIB_PATH . 'layout' . DS . 'layout.php')) {
                   if (file_exists(VIEW_PATH . $this->controller . DS . $this->view_file . VIEW_EXT)) {
            require (VIEW_PATH . $this->controller . DS . $this->view_file . VIEW_EXT);

        } else {
            require LIB_PATH . 'layout' . DS . '404.php';
        }
                }
            }
            include (LIB_PATH . 'layout' . DS . 'footer.php');

        endif;
    }




    function render_to($controller, $view, $data = null)
    {   
        $this->data = $data;
        $this->controller = $controller;
        $this->view($view,$data);
    }
}
