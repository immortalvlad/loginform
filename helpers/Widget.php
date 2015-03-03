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
        foreach ($lang_arr["data"] as $lang => $langValue)
        {
            $result .= " <a href='/" . $lang . "/" . $langValue['url'] . "'>" . $langValue["name"] . "</a> ";
        }
        return $result;
    }

    private static function URL()
    {
        return Router::init()->getController() . "/" . Router::init()->getAction();
    }

}
