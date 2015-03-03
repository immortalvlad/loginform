<?php

/**
 * Description of Widget
 *
 * @author immortalvlad
 */
class Widget {

    public static function langSwitcer()
    {
        $langs = Language::init()->getlanguages();
        foreach ($langs as $lang)
        {
            $lang_arr["data"][$lang] = array(
                    "url" => self::Url(),
                    "name" => App::app()->t($lang)
            );
        }

//        Helper::PR($lang_arr);
        $result = "";
        $curLang = Language::init()->getLang();
        foreach ($lang_arr["data"] as $lang => $langValue)
        {
            if ($curLang == $lang)
            {
                $result .= " <span>" . $langValue["name"] . "</span> |";
            } else
            {
                $result .= " <a href='/" . $lang . "/" . $langValue['url'] . "'>" . $langValue["name"] . "</a> |";
            }
        }
        $result = substr($result, 0, -1);
        return $result;
    }

    private static function URL()
    {
        return Router::init()->getController() . "/" . Router::init()->getAction();
    }

}
