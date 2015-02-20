<?php

/**
 * Description of UserEntityModel
 *
 * @author immortalvlad
 */
class UserpictureModel extends Model {

    protected $tableName = "user_picture";
    protected static $_instance;

    private function __construct()
    {
        $this->mainModel();
    }

    /**
     * 
     * @return self
     */
    public static function model()
    {
        if (null === self::$_instance)
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

}
