<?php

/**
 * Language class 
 *
 * @author immortalvlad
 */
class Language {

    private static $_instance;
    private $_lang;

    public function __construct()
    {
        $defaultLang = Config::get("defaultLanguage");
        $this->_lang = $defaultLang;
    }

    public static function init()
    {
        if (self::$_instance == null)
            self::$_instance = new self();
        return self::$_instance;
    }

    public function getLang()
    {
        return $this->_lang;
    }

    public function setLang($lang)
    {
        $languages = Config::get("languages");
        if (is_array($languages) && !empty($languages) && in_array($lang, $languages))
        {
            $this->_lang = $lang;
        }
    }

}
