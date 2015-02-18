<?php

/**
 * View base class file
 *
 * @project ApPHP Framework
 * @author ApPHP <info@apphp.com>
 * @link http://www.apphpframework.com/
 * @copyright Copyright (c) 2012 ApPHP Framework
 * @license http://www.apphpframework.com/license/
 *
 * PUBLIC:					PROTECTED:					PRIVATE:		
 * ----------               ----------                  ----------
 * __set
 * __get
 * setMetaTags
 * render
 * setTemplate
 * setController
 * setAction
 * getContent
 * 
 * STATIC:
 * ---------------------------------------------------------------
 * 
 */
class View {

    /** 	@var string */
    private $_template;

    /** 	@var mixed */
    private $_content;

    /** @var string */
    private $_controller;

    /** @var string */
    private $_action;

    /** 	@var string */
    private $_breadCrumbs;

    /** 	@var string */
    private $_activeMenu;

    /** 	@var string */
    private $_pageTitle;

    /** 	@var string */
    private $_pageKeywords;

    /** 	@var string */
    private $_pageDescription;

    /** @var array */
    private $_vars = array();

    /**
     * 	Setter method
     * 	@param string $index
     * 	@param mixed $value
     */
    public function __set($index, $value)
    {
        $this->_vars[$index] = $value;
    }

    /**
     * 	Getter method
     * 	@param string $index
     */
    public function __get($index)
    {
        return isset($this->_vars[$index]) ? $this->_vars[$index] : '';
    }

    /**
     * 	Sets meta tags for page
     * 	@param string $tag
     * 	@param mixed $value
     */
    public function setMetaTags($tag, $val)
    {
        if ($tag === 'title')
        {
            $this->_pageTitle = $val;
        } else if ($tag === 'keywords')
        {
            $this->_pageKeywords = $val;
        } else if ($tag === 'description')
        {
            $this->_pageDescription = $val;
        }
    }

    /**
     * Render a view with template
     * @param string $params (controller/view or hidden controller/view)
     * @throws Exception
     * @return void
     */
    public function render($params)
    {
        try
        {
            $isTemplateFound = true;

            $paramsParts = explode('/', $params);

            // set default controller and action
            $controller = $this->_controller;
            $view = $this->_action;

            // set controller and action according to passed params
            if (!empty($params))
            {
                $parts = count($paramsParts);
                if ($parts == 1)
                {
                    $controller = $this->_controller;
                    $view = isset($paramsParts[0]) ? $paramsParts[0] : $this->_action;
                } else if ($parts >= 2)
                {
                    $controller = isset($paramsParts[0]) ? $paramsParts[0] : $this->_controller;
                    $view = isset($paramsParts[1]) ? $paramsParts[1] : $this->_action;
                }
            }

            if (APPHP_MODE == 'test')
            {
                return $controller . '/' . $view;
            } else
            {
                $template = APP_PATH . DS . 'templates' . DS . (!empty($this->_template) ? $this->_template . DS : '') . 'default.php';
                if (!file_exists($template))
                {
                    $isTemplateFound = false;
                    if (!empty($this->_template))
                    {
                    }
                }
                $appFile = APP_PATH . DS . 'protected' . DS . 'views' . DS . $controller . DS . $view . '.php';
                $viewFile = $appFile;
                if (is_file($viewFile))
                {
                    // check application view
                } else
                {
                    // check component view
                    $componentView = APP_PATH . DS . 'protected' . DS . App::app()->mapAppModule($controller) . 'views' . DS . $controller . DS . $view . '.php';
                    if (is_file($componentView))
                    {
                        $viewFile = $componentView;
                    }
                }

                foreach ($this->_vars as $key => $value)
                {
                    $$key = $value;
                }
                ob_start();
                include $viewFile;
                $this->_content = ob_get_contents();
                ob_end_clean();

                if ($isTemplateFound)
                {
                    ob_start();
                    include $template;
                    $template_content = ob_get_contents();
                    ob_end_clean();

                    // render registered scripts					
                    App::app()->getClientScript()->render($template_content);

                    echo $template_content;
                } else
                {
                    echo $this->_content;
                }
            }
        } catch (Exception $e)
        {
        }
    }

    /** 	 
     * Template setter
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->_template = $template;
    }

    /** 	 
     * Controller setter
     * @param string $controller
     */
    public function setController($controller)
    {
        $this->_controller = $controller;
    }

    /** 	 
     * Action setter
     * @param string $action
     */
    public function setAction($action)
    {
        $this->_action = $action;
    }

    /** 	 
     * Action getter
     * @return mixed content (HTML code)
     */
    public function getContent()
    {
        return $this->_content;
    }

}
