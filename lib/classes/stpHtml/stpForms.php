<?

/**
 * This file is the default application form class.It extends the stpHtml class file. You can put all for related elements here.
 * it is still currently still under development.
 *
 * PHP versions 4 and 5
 */


#doc
#    classname:    stpForms extends
#    scope:        PUBLIC
#
#/doc
#extens stpHtml into forms category.


class stpForms extends stpHtml
{

    var $action;
    var $method;
    var $value;
    var $input_type;
    var $option_default;


    function __construct()
    {
        $this->value = '';
        $this->input_type = 'text';
        $this->attr_sep = parent::$attr_sep;
    }


    //Public methods

    function startForm($action = null, $method = null, $attributes = null, $form_body = null,
        $no_display = null)
    {

        if (!preg_match('/action/', "$attributes")) {
            if (trim($action) == '') {
                $this->action = "#";
            } else {
                $this->action = $action;
            }
            $attributes .= $this->attr_sep.' action,' . $this->action. $this->attr_sep;
        }
        if (!preg_match('/method/', "$attributes")) {
            if (((trim($method) != 'POST') && (trim($method) != 'GET'))) {
                $this->method = "POST";
            } else {
                $this->method = strtoupper($method);
            }
            $attributes .= $this->attr_sep . 'method,' . $this->method. $this->attr_sep;
        }
        $this->autoConstructTags('form', $form_body, $attributes, $no_display);

    }

    function endForm($no_display = null)
    {

        $this->cTag('form', $no_display);

    }

    //default input
    function input($input_type = null, $attributes = null, $value = null, $no_display = null)
    {
        if (!preg_match('/value/', "$attributes")) {
            if (trim($value) != '') {
                $attributes .= $this->attr_sep . 'value,' . $value;
            }
        } else {
            if (isset($value) && (trim($value) != '')) {
                $attributes .= '|value,' . $value;
            }
        }

        if (!preg_match('/type/', "$attributes")) {
            if (trim($input_type) != '') {
                $attributes .= $this->attr_sep . 'type,' . $input_type;
            }
        } else {
            $attributes = $this->attr_sep . 'type,text';
        }
        $this->autoConstructTags('input', $this->value, $attributes, $no_display);
    }


    function text($value = null, $attributes = null, $no_display = null)
    {
        $this->input('text', $attributes, $value, $no_display);
    }
    
    function int($value = null, $attributes = null, $no_display = null)
    {
        $this->input('int', $attributes, $value, $no_display);
    }

    function password($value = null, $attributes = null, $no_display = null)
    {
        $this->input('password', $attributes, $value, $no_display);
    }
	
	function hidden($value = null, $attributes = null, $no_display = null)
    {
        $this->input('hidden', $attributes, $value, $no_display);
    }

    function checkbox($value = null, $attributes = null, $no_display = null)
    {
        $this->input('checkbox', $attributes, $value, $no_display);
    }

    function submit($value, $attributes = null, $no_display = null)
    {
        $this->input('submit', $attributes, $value, $no_display);
    }

    function reset($value, $attributes = null, $no_display = null)
    {
        $this->input('reset', $attributes, $no_display);
    }


    //fieldset o for opening tag c for closing
    function oFieldset($label = null, $attributes = null, $no_display = null)
    {


        $this->oTag('fieldset', $attributes, $label, $no_display);

    }

    function cFieldset($no_display = null)
    {

        $this->cTag('fieldset', $no_display);
    }


    //select field
    function select($list_elements = null, $sel_attributes = null, $opt_attributes = null,
        $default = null, $use_array_as_it_is = null, $no_display = null)
    {

        $this->oTag('select', $sel_attributes.'| ');
        if (is_array($list_elements)) {
            if(isset($default) && trim($default) != ''){
                        $this->option($default, "value, | " . $opt_attributes." | ");                                           
                    }
            foreach ($list_elements as $list => $value):

                if (is_array($list_elements[$list])) {
                    if(isset($use_array_as_it_is)){
                        foreach($list_elements[$list] as $list_arryed_key =>$list_arryed_value){
                            $this->option($list_arryed_value, "value,$list_arryed_key |  $opt_attributes, | ");
                        }
                    }else{
                      $this->option('!Array!', 'style,background:#ff6666; | ');  
                    }
                    
                } else {
                    $this->option($value, "value,$list |  $opt_attributes, | ");
                }
            endforeach;
        } else {
            $list_elements = trim($list_elements);
            if ($list_elements != '') {
                $this->option($list_elements, $opt_attributes.' | ');
            }
        }
        $this->cTag('select');
    }

    function option($message = null, $attributes = null)
    {
        if (isset($message)) {
        $this->autoConstructTags('option', $message, $attributes);
        }
    }


    //label self opens and closes
    function label($label = null, $for = null, $attributes = null, $no_display = null)
    {

        if ($for) {
            $attributes .= $this->attr_sep . 'for,' . $for;
        }
        if (!$label) {
            $label = '&nbsp;';
        }
        $this->autoConstructTags('label', $label, $attributes, $no_display);
    }


    //textarea, self opens and closes
    function textarea($rows = null, $cols = null, $attributes = null, $value = null,
        $no_display = null)
    {

        if ($cols) {
            if (is_int($cols)) {
                $attributes .= $this->attr_sep . 'cols,' . $cols;
            } else {
                echo "the second argument (cols) should be an intger ";
            }
        }

        if ($rows) {
            if (is_int($rows)) {
                $attributes .= $this->attr_sep . 'rows,' . $rows;
            } else {
                echo "the second argument (rows) should be an intger ";
            }
        }
        $this->autoConstructTags('textarea', $value, $attributes, $no_display);
    }


}

?>
