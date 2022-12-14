<?php
class Form
{

    public static function label($name)
    {
        return sprintf('<label class="font-weight-bold">%s</label>', $name);
    }

    public static function input($type, $name, $value)
    {
        return sprintf('<input class="form-control" type="%s" name="%s" value="%s">', $type, $name, $value);
    }

    public static function selectBox($values, $name, $keySelected)
    {

        $xhtml = "<select class='custom-select' name='$name'>";
        foreach ($values as $key => $value) {
            $selected =  $keySelected == $key ? 'selected' : '';
            $xhtml .= sprintf('<option value="%s" %s >%s</option>', $key, $selected, $value);
        }
        $xhtml .= '</select>';
        return $xhtml;
    }
    public static function formRow($label, $element)
    {
        return $xhtml = sprintf('<div class="form-group">
        %s 
        %s
        </div>', $label, $element);
    }
}