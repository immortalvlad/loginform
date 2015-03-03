<?php

class Captcha {

    protected $chars = 'ABCDEFGHKLMNPQRSTUVWYZ123456789';
    protected $file;
    protected $fontFile;

    public function __construct()
    {
        $this->file = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . "/" . Config::get('pathToTheme') . "/captcha/bg5.png";
        $this->fontFile = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . "/" . Config::get('pathToTheme') . "/captcha/FFF_Tusj.ttf";
    }

    function Generate($width = 100, $height = 30, $length = 6)
    {
        $NewImage = imagecreatefrompng($this->file);

        $TextColor = imagecolorallocate($NewImage, 0, 0, 0);
        $line_clr = imagecolorallocate($NewImage, 100, 100, 100);
        imageline($NewImage, 0, $height - 22, $width, $height - 1, $line_clr);
        imageline($NewImage, $width - 1, 0, $width - 100, $height, $line_clr);
        imageline($NewImage, $height - 1, 0, $width - 100, $width, $line_clr);
        imageline($NewImage, $width - 1, 0, $height - 1, $width, $line_clr);
        $x = -10;
        $resulttext='';
        for ($i = 0; $i < $length; $i++)
        {
            $pos = mt_rand(0, strlen($this->chars) - 1);
            $x+=20;
            $ResultStr = substr($this->chars, $pos, 1);
            $resulttext .=$ResultStr; 
            imagettftext($NewImage, 20, rand(-5, 10), $x, rand(20, 30), $TextColor, $this->fontFile, $ResultStr);
        }

        Session::init()->set(Config::get('captcha_name'), strtolower($resulttext));

        header("Content-type: image/jpeg");
        imagejpeg($NewImage);
    }

    public static function isValid($entered_captcha)
    {
        if(!Session::init()->isExists(Config::get('captcha_name')))
            return false;
        $session_captcha = Session::init()->get(Config::get('captcha_name'));
        if ($session_captcha === $entered_captcha)
        {
            Session::init()->deleteSession($session_captcha);
            return true;
        }
        return false;
    }

}

?>