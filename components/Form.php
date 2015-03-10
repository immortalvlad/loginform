<?php

/**
 * Description of Form
 *
 * @author immortalvlad
 */
class Form {

    public $useToken = true;
    public $tokenName = '';

    /**
     * The array of Models 
     * @var Model
     */
    protected $_models = array();
    private $_errors = array();
    private $_rules = array();
    private $_success = false;
    private $_fieldsErrors = array();

    public function __construct($models = array())
    {

        $this->tokenName = Config::get('token_name');
        if (!empty($models))
        {
            $models = !is_array($models) ? array($models) : $models;
            foreach ($models as $model)
            {
                if ($model instanceof Model)
                {
                    $this->_models[] = $model;
                }
            }
        }
        $this->generateRules();
    }

    protected function generateRules()
    {
        $arr = array();
        if (!empty($this->_models))
        {
            foreach ($this->_models as $model)
            {
                $mer = $model->getRules();
                $mer[$model->getTableName()]["model"] = $model;
                $arr += array_merge($arr, $mer);
            }
        }

        $this->_rules = $arr;
    }

    public function showModels()
    {
        return $this->_models;
    }

    public function validate()
    {
//        Helper::PR($this->_rules);
        foreach ($this->_rules as $table => $table_rules)
        {
            foreach ($table_rules as $table_rule => $rule_values)
            {
                foreach ($rule_values as $rule_name => $rule_value)
                {
//                     echo $table . " = " . $table_rule . "=" . $rule_name . " = " . $rule_value . " <br>";
//                     echo $table . " = " . $table_rule . "=" . $rule_name . " =  <br>";
                    $value = trim(InputRequest::getFormPost($table, $table_rule));
                    $table_rule = Filter::sanitize('', $table_rule);
                    /* @var $mod Model  */
                    $mod = $table_rules["model"];
                    $table_rule_t = $mod->getField($table_rule);
//                    $table_rule_t = Translate::t($table_rule);
                    if ($rule_name == "required" && empty($value))
                    {

                        $m = Translate::t("$1 cannot be blank.", $table_rule_t);
                        $this->addError($m);
                        $this->addFieldError($table, $table_rule, $m);
                    } else if (!empty($value) || $rule_name == 'type')
                    {
                        switch ($rule_name)
                        {
                            case 'min':
                                if (strlen($value) < $rule_value)
                                {
                                    $m = Translate::t("$1 is too short (minimum is $2 characters).", array($table_rule_t, $rule_value));
                                    $this->addError($m);
                                    $this->addFieldError($table, $table_rule, $m);
                                }
                                break;
                            case 'max':
                                if (strlen($value) > $rule_value)
                                {
                                    $m = Translate::t("$1 is too long (maximum is $2 characters).", array($table_rule_t, $rule_value));
                                    $this->addError($m);
                                    $this->addFieldError($table, $table_rule, $m);
                                }
                                break;
                            case 'matches':
                                if ($value != InputRequest::getFormPost($table, $rule_value))
                                {
                                    $m = Translate::t("$1 must be $2.", array($rule_value, $table_rule_t));
                                    $this->addError($m);
                                    $this->addFieldError($table, $table_rule, $m);
                                }
                                break;
                            case 'unique':

                                $res = $rule_value::model()->getPkByField($table_rule, $value);

                                if ($res)
                                {
                                    $m = Translate::t("Field $1 with  value $2  already exist.", array($table_rule_t, $value));
                                    $this->addError($m);
                                    $this->addFieldError($table, $table_rule, $m);
                                }
                                break;
                            case 'type':


                                switch ($rule_value)
                                {
                                    case 'captcha':
                                        if (!Captcha::isValid(strtolower(InputRequest::getFormPost($table, $rule_value))))
                                        {
                                            $m = Translate::t("Vrong captcha");
                                            $this->addError($m);
                                            $this->addFieldError($table, $table_rule, $m);
                                        }
                                        break;
                                    case 'email':
                                        if (!Filter::sanitize('ValidateEmail', InputRequest::getFormPost($table, $rule_value)))
                                        {
                                            $m = Translate::t("Field $1 is not a valid email address.", $table_rule_t);
                                            $this->addError($m);
                                            $this->addFieldError($table, $table_rule, $m);
                                        }
                                        break;
                                    case 'login':
                                        if (!Filter::sanitize('ValidateLogin', $value) && $value)
                                        {
                                            $m = Translate::t("Incorect $1, use only letters or digits", $table_rule_t);
                                            $this->addError($m);
                                            $this->addFieldError($table, $table_rule, $m);
                                        }
                                        break;
                                    case 'phone':
                                        if (!Filter::sanitize('phone', $value) && $value)
                                        {
                                            $m = Translate::t("The format of $1 is invalid.", $table_rule_t);
                                            $this->addError($m);
                                            $this->addFieldError($table, $table_rule, $m);
                                        }
                                        break;

                                    case 'image':
                                        $allowed = Config::get('file_allowed');
                                        $maxSize = Config::get('file_max_size');
//                                        InputRequest::getFormPost($table, $rule_value);
                                        if (!isset($_FILES[$table]))
                                        {
                                            continue;
                                        }
                                        if (is_array($_FILES[$table]['error'][$table_rule]))
                                        {                                           
                                            $str = implode(', ', $allowed);
                                            $m = Translate::t("The file cannot be uploaded. Only files with these extensions are allowed: $1.", $str);
                                            $this->addError($m);
                                            $this->addFieldError($table, $table_rule, $m);
                                            continue;
                                        }
                                        if (isset($_FILES[$table]) && $_FILES[$table]['error'][$table_rule] == 0)
                                        {
                                            $extension = pathinfo($_FILES[$table]['name'][$table_rule], PATHINFO_EXTENSION);

                                            if (!in_array(strtolower($extension), $allowed))
                                            {                                             
                                                $str = implode(', ', $allowed);
                                                $m = Translate::t("The file cannot be uploaded. Only files with these extensions are allowed: $1.", $str);
                                                $this->addError($m);
                                                $this->addError($m);
                                                $this->addFieldError($table, $table_rule, $m);
                                            }
                                            if ($_FILES[$table]['size'][$table_rule] > $maxSize)
                                            {
                                                $m = Translate::t("The file is too large. Its size cannot exceed $1 bytes.",$maxSize);
                                                $this->addError($m);
                                                $this->addFieldError($table, $table_rule, $m);
                                            }
                                        }
                                        break;
                                    default:
                                        break;
                                }
                                break;
                            default:
                                break;
                        }
                    }
                }
            }
        }
        $isvalid = $this->isTokenValid();
        if (empty($this->_errors) && $isvalid)
        {
            return $this->_success = true;
        }
        return false;
    }

    public function generateToken()
    {
        return Token::generate();
    }

    public function isTokenValid()
    {
        if ($this->useToken)
        {
            $tokenVal = InputRequest::getPost($this->tokenName);
            if (Token::isValid($tokenVal))
            {
                return true;
            } else
            {
                $m = Translate::t("Token is not valid");
                $this->addError($m);
                return FALSE;
            }
        }
        return true;
    }

    public function isRequired(Model $model, $field)
    {
        return $model->isRequired($field);
    }

    public function getName(Model $model, $field)
    {
        return $model->getField($field);
    }

    public function getError(Model $model, $field)
    {
        $table = $model->getTableName();
        return isset($this->_fieldsErrors[$table][$field]) ? $this->_fieldsErrors[$table][$field] : false;
    }

    public function success()
    {
        return $this->_success;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function addError($error)
    {
        $this->_errors[] = $error;
    }

    public function getFieldsErrors()
    {
        return $this->_fieldsErrors;
    }

    public function getRules()
    {
        return $this->_rules;
    }

    public function getFieldError($table = '', $field = '')
    {
        return isset($this->_fieldsErrors[$table][$field]) ? $this->_fieldsErrors[$table][$field] : false;
    }

    public function addFieldError($table, $field, $value)
    {
        $this->_fieldsErrors[$table][$field] = $value;
    }

    public function ToJson()
    {
        $res = "[";
        foreach ($this->_rules as $table => $table_rules)
        {
            $res.="{\"{$table}\":[";
            foreach ($table_rules as $table_rule => $rule_values)
            {
                $res.="{\"{$table_rule}\":[";
                foreach ($rule_values as $rule_name => $rule_value)
                {
                    if (is_object($rule_value) || empty($rule_value) || $rule_value == "")
                    {
                        $rule_value = 'obj';
                    }
                    $res.="{\"{$rule_name}\":\"{$rule_value}\"},";
                }
                $res = substr($res, 0, -1);
                $res.="]},";
            }
            $res = substr($res, 0, -1);
            $res.="]},";
        }
        $res = substr($res, 0, -1);
        return $res . "]";
    }

}
