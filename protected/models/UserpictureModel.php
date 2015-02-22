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

    public function rules()
    {
        return array(
                  // array('', 'required'),
        );
    }

    public function attributeLabels()
    {
        return array(
                $this->tableName => array(
                        'path' => App::app()->t("path"),
                        'type' => App::app()->t("type"),
                )
        );
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
