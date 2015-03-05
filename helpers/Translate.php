<?php

/**
 * Description of Translate
 *
 * @author immortalvlad
 */
class Translate {

    public static function t($key, $replace_text = array())
    {
        $classCoreDir = APP_PATH . DS . 'protect';
        $lang = App::app()->getLanguage()->getLang();
        $defLang = Config::get("defaultLanguage");
        $langFile = $classCoreDir . DS . 'lang' . DS . $lang . '.php';
        $defFile = '';
        if ($lang != $defLang)
        {
            $defFile = $classCoreDir . DS . 'lang' . DS . $defLang . '.php';
        }

        if ($text = self::getText($langFile, $key))
        {
            $text;
        } else if ($text = self::getText($defFile, $key))
        {
            $text;
        } else
        {
            $text = $key;
        }
        if (!empty($replace_text) || $replace_text != "")
        {
            $replace_text = !is_array($replace_text) ? array($replace_text) : $replace_text;
            $patterns = array();
            foreach ($replace_text as $index => $value)
            {
                $index++;
                $patterns[] = '/\$' . $index . '/';
            }
            $text = preg_replace($patterns, $replace_text, $text);
        }

        return $text;
    }

    public static function ToJson()
    {
        $classCoreDir = APP_PATH . DS . 'protect';
        $lang = App::app()->getLanguage()->getLang();
        $langFile = $classCoreDir . DS . 'lang' . DS . $lang . '.php';
        if (is_file($langFile))
        {
            $texts = require($langFile);
            return json_encode($texts,JSON_UNESCAPED_UNICODE);
        }
    }

    private static function getText($File, $key)
    {
        if (is_file($File))
        {
            $langText = require($File);
        }
        if (isset($langText[$key]))
        {
            return $langText[$key];
        } else
        {
            return false;
        }
    }

}
