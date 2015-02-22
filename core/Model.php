<?php

/**
 * Description of Model
 *
 * @author immortalvlad
 */
abstract class Model {

    protected $db;
    protected $tableName;

    protected function mainModel()
    {
        $this->db = DB::getInstance()->getConnection();
        $this->prfx = DB::getInstance()->getPrefix();
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * Select records by id
     * @param int  $id
     * @return array
     */
    public function selectById($id)
    {
        $result = $this->db->prepare("SELECT * FROM `" . $this->prfx . $this->tableName . "`  WHERE `user_entity_id` = " . $id . " ");

        $result->execute();
        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * Insert record 
     * @param array $nameField name fieald in table
     * @param array $values values to insert
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
                $values .= "'" . $value . "',";
            }
        }
        $Fields = substr($Fields, 0, -1);
        $values = substr($values, 0, -1);
        $stmt = $this->db->prepare("INSERT INTO " . $this->tableName . "(" . $Fields . " ) VALUES(" . $values . ")");
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    /**
     * Delete record by id
     * @param string  $name
     * @param int  $id
     * @return int or false
     */
    public function deleteById($name = '', $id = '')
    {
        if ($id != "" && $name != "")
        {
            $stmt = $this->db->prepare("DELETE FROM " . $this->tableName . " WHERE `" . $name . "`=:id");
            $stmt->bindValue(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            return $affected_rows = $stmt->rowCount();
        } else
        {
            return FALSE;
        }
    }

}
