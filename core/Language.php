<?php

/**
 * Language class 
 *
 * @author immortalvlad
 */
class Language {

    private static $_instance;
    private $_lang;
    private $cookieLangName = 'lang';

    public function __construct()
    {
        if (!Session::init()->isExists($this->cookieLangName))
        {
            $defaultLang = Config::get("defaultLanguage");
            $this->setLang($defaultLang);
        }
    }

    /**
     * 
     * @return self
     */
    public static function init()
    {
        if (self::$_instance == null)
            self::$_instance = new self();
        return self::$_instance;
    }
    /**
     * Return current site languege
     * @return string
     */
    public function getLang()
    {
        return $this->_lang;
    }

    /**
     * Return all available languages in site
     * @return array
     */
    public function getlanguages()
    {
        $config = Config::get("languages");
        if (!empty($config))
        {
            return Config::get("languages");
        } else
        {
            return array(Config::get("defaultLanguage"));
        }
    }
    /**
     * Set site languege
     * @param string Language
     */
    public function setLang($lang)
    {
        $languages = Config::get("languages");
        if (is_array($languages) && !empty($languages) && in_array($lang, $languages))
        {
            $this->_lang = $lang;
          //  Session::init()->set($this->cookieLangName, $lang);
            Session::init()->setCookie($this->cookieLangName, $lang,  Config::get('cookie_lang_expiry'));
        }
    }

}
