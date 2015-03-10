<?php

/**
 * Description of Model
 *
 * @author immortalvlad
 */
abstract class Model {

    protected $db;
    protected $conn;
    protected $tableName;
    protected $_primaryKey;
    protected $rules = array();
    protected $attributeLabels = array();

    abstract function rules();

    abstract function attributeLabels();

    protected function mainModel()
    {
        $this->db = DB::getInstance();
        $this->conn = $this->db->getConnection();
        $this->prfx = DB::getInstance()->getPrefix();
        $this->rules = $this->rules();
        $this->attributeLabels = $this->attributeLabels();
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function unsetRule($field, $rule)
    {
        unset($this->rules[$this->tableName][$field][$rule]);
    }

    public function delRule($field)
    {
        unset($this->rules[$this->tableName][$field]);
    }

    public function addRule($field, $values, $description = '')
    {
        $this->rules[$this->tableName][$field] = $values;
        if ($description)
        {
            $this->setAttributeLabel($field, $description);
        }
    }

    public function setAttributeLabel($field, $value)
    {
        $this->attributeLabels[$this->tableName][$field] = $value;
    }

    public function getField($fieldName)
    {
        $arr = $this->attributeLabels;
        if (!empty($arr[$this->tableName][$fieldName]))
        {
            return $arr[$this->tableName][$fieldName];
        }
        return FALSE;
    }

    public function isRequired($field = '')
    {
        $arr = $this->rules();
//        Helper::PR($arr);
        if (!empty($arr) && $field != '' && isset($arr[$this->tableName][$field]))
        {
//            Helper::PR( $arr[$this->tableName][$field]);
            return isset($arr[$this->tableName][$field]['required']) ? true : FALSE;
        }
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function getPK()
    {
        return $this->_primaryKey;
    }

    /**
     * Select records by id
     * @param int  $id
     * @return array
     */
    public function selectById($id)
    {
        $sql = "SELECT * FROM `" . $this->prfx . $this->tableName . "`  WHERE `{$this->_primaryKey}` = ?";

        return $result = $this->db->query($sql, array($id));
    }

    public function selectAll($fields = array())
    {
        if (!empty($fields))
        {
            $fields = implode(', ', $fields);
        } else
        {
            $fields = '*';
        }
        $sql = "SELECT {$fields} FROM `" . $this->prfx . $this->tableName . "`";

        return $result = $this->db->query($sql);
    }

    /**
     * Insert record 
     * @param array $nameField name fieald in table
     * @return int last inserted value
     */
    public function insert($nameField)
    {
        $Fields = "";
        $values = "";
        if (!empty($nameField))
        {
            foreach ($nameField as $key => $value)
            {
                $Fields .= "`" . $key . "`,";
                $values .= " ?,";
            }
        }
        $Fields = substr($Fields, 0, -1);
        $values = substr($values, 0, -1);
        $sql = "INSERT INTO " . $this->tableName . "(" . $Fields . " ) VALUES(" . $values . ")";
        if ($this->db->query($sql, $nameField, "insert"))
        {
            return $this->conn->lastInsertId();
        }
    }

    /**
     * Update record
     * @param int $id  Updated id
     * @param array $fields Updated fields
     * @return boolean
     */
    public function update($id, $fields)
    {
        $set = '';
        $x = 1;
        foreach ($fields as $name => $value)
        {
            $set .="{$name} = ?,";
        }
        $set = substr($set, 0, -1);
        $sql = "UPDATE {$this->tableName} SET {$set} WHERE {$this->_primaryKey} = {$id}";
        if (!$this->db->query($sql, $fields))
        {
            return true;
        }

        return false;
    }

    public function find($field, $value)
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE {$field} = ?";
        $res = $this->db->query($sql, array($value));
        if (!empty($res))
        {
            return $res;
        }
        return false;
    }

    public function getPkByField($field, $value)
    {
        $PK = $this->_primaryKey;
        $sql = "SELECT {$PK} FROM {$this->getTableName()} WHERE {$field} = ? LIMIT 1";
        $res = $this->db->query($sql, array($value));
        if (!empty($res))
        {
            return $res;
        }
        return false;
    }

    /**
     * Delete record by id
     * @param string  $name
     * @param int  $id
     * @return int or false
     */
    public function deleteById($id = '')
    {
        if ($id != "")
        {
            $stmt = $this->conn->prepare("DELETE FROM " . $this->tableName . " WHERE `{$this->_primaryKey}`=:id");
            $stmt->bindValue(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            return $affected_rows = $stmt->rowCount();
        } else
        {
            return FALSE;
        }
    }

}
