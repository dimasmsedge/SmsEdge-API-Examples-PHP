<?php

class validation
{

    public $errors = [];

    /**
     * @param $field
     * @return string
     */
    private function input($field)
    {
        return strip_tags(trim($field));
    }

    /**
     * @param $field
     * @param $message
     */
    private function pushToError($field, $message)
    {
        $this->errors[$field][] = $message;
    }

    /**
     * @param $field
     * @param $input
     */
    private function required($field, $input)
    {
        if (empty($input)) {
            $this->pushToError($field,'is required');
        }
    }

    /**
     * @param $field
     * @param $input
     */
    private function string($field, $input)
    {
        if (!is_string($input)) {
            $this->pushToError($field, 'is not a string');
        }
    }

    /**
     * @param $field
     * @param $input
     */
    private function numeric($field, $input)
    {
        if (!is_numeric($input)) {
            $this->pushToError($field,'is not an numeric value');
        }
    }

    /**
     * @param $field
     * @param $input
     */
    private function integer($field, $input){
        if (!is_int($input)) {
            $this->pushToError($field, 'is not an integer');
        }
    }

    /**
     * @param $field
     * @param $input
     * @param $length
     */
    private function max($field, $input, $length)
    {
        if (strlen($input) > $length) {
            $this->pushToError($field, 'is too long. need to be ' . $length . ' characters');
        }
    }

    /**
     * @param $field
     * @param $input
     * @param $length
     */
    private function min($field, $input, $length)
    {
        if (strlen($input) < $length) {
            $this->pushToError($field,'is too short. need to be ' . $length . ' characters');
        }
    }

    /**
     * @param $field
     * @param $input
     */
    private function email($field, $input)
    {
        if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $this->pushToError($field,'is not an email');
        }
    }

    /**
     * @param $field
     * @param $input
     */
    private function boolean($field, $input){
        if(!is_bool($input)){
            $this->pushToError($field,'is not a boolean');
        }
    }

    /**
     * @param $rules
     * @param $fields
     * @throws Exception
     */
    public function validate($rules, $fields)
    {

        foreach ($rules as $field => $rule) {

            if (!array_key_exists($field, $fields) && strpos($rule, 'nullable') === false) {
                throw new Exception('Can\'t find index "' . $field . '" in given data.');
            }

            $nullable = strpos($rule, 'nullable') !== false;

            $rules_arr = explode('|', $rule);
            foreach ($rules_arr as $rul) {

                if (strpos($rul, ':') !== false) {
                    $rule_with_params = explode(':', $rul);
                    if (key_exists($field, $fields)){
                        $this->$rule_with_params[0]($field, $this->input($fields[$field]), $rule_with_params[1]);
                    }else{
                        if (!$nullable){
                            throw new Exception('Index "' . $field . '" can\'t be NULL');
                        }
                    }
                } else {
                    if ($rul != 'nullable'){
                        if (key_exists($field, $fields)){
                            $this->$rul($field, $this->input($fields[$field]));
                        }else{
                            if (!$nullable){
                                throw new Exception('Index "' . $field . '" can\'t be NULL');
                            }
                        }
                    }
                }

            }
        }
    }

    /**
     *
     */
    public function showErrors(){
        echo '<pre>';
        print_r($this->errors);
        die();
    }


    /**
     * @return bool
     */
    public function run()
    {
        if (empty($this->errors)) {
            return true;
        } else {
            return false;
        }
    }

}