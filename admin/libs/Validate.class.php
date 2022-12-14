<?php
class Validate
{
    private $errors = array();
    private $data = array();
    private $rules = array();
    private $result = array();

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function addRules($rules)
    {
        $this->rules = array_merge($this->rules, $rules); //! vi goi lai no se tao mang moi nen su dung phuong thuc gop mang
    }
    public function addRule($element, $type, $min = 0, $max = 0)
    {
        $this->rules[$element] = array('type' => $type, 'min' => $min, 'max' => $max);
        return $this;
    }
    public function run()
    {
        foreach ($this->rules as $element => $value) {
            switch ($value['type']) {
                case 'int':
                    $this->validateInt($element, $value['min'], $value['max']);
                    break;
                case 'url':
                    $this->validateUrl($element);
                    break;
                case 'email':
                    $this->validateEmail($element);
                    break;
                default:
                    $this->validateString($element, @$value['min'], $value['max']);
                    break;
            }
            if (!array_key_exists($element, $this->errors)) {
                $this->result[$element] = $this->data[$element];
            }
        }
    }
    private function validateInt($element, $min, $max)
    {
        $options = array(
            'options' => array(
                'min_range' => $min,
                'max_range' => $max,
            ),
        );
        if (!(filter_var($this->data[$element], FILTER_VALIDATE_INT, $options))) {
            $this->errors[$element] = "$element is an invalid number!";
        }
    }
    private function validateUrl($element)
    {
        if (!filter_var($this->data[$element], FILTER_VALIDATE_URL)) {
            $this->errors[$element] = "$element is an invalid url";
        }
    }

    private function validateEmail($element)
    {
        if (!filter_var($this->data[$element], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$element] = "$element is an invalid Email";
        }
    }

    private function validateString($element, $min, $max)
    {
        $options = array(
            "options" => array(
                'regexp' => "/^([a-zA-Z' ]+)$/",
            ),
        );
        if (!filter_var($this->data[$element], FILTER_VALIDATE_REGEXP, $options)) {
            $this->errors[$element] = "$element is not valid";
        }
    }


    public function getErrors()
    {
        return $this->getErrors;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function showErrors()
    {
        $xhtml = '<div class="alert alert-danger" role="alert"><ul>';
        if (!empty($this->errors)) {
            foreach ($this->errors as $value) {
                $xhtml .= "<li>$value</li>";
            }
        }
        $xhtml .= "</div></ul>";
        return $xhtml;
    }

    public function showData()
    {
        echo '<pre>';
        print_r($this->data);
        echo '</pre>';
    }

    public function showResult()
    {
        echo '<pre>';
        print_r($this->result);
        echo '</pre>';
    }

    public function isValid()
    {
        if (empty($this->errors)) {
            return 1;
        }
        return 0;
    }
}