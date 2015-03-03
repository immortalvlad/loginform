<?php

/**
 * View base class file
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
     * Render a view with template
     * @param string $params (controller/view or hidden controller/view)
     * @throws Exception
     * @return void
     */
    public function render($params, $part = false)
    {
        try
        {

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

            $appFile = APP_PATH . DS . 'protect' . DS . 'views' . DS . $controller . DS . $view . '.php';
            $viewFile = $appFile;
            if (is_file($viewFile))
            {
                foreach ($this->_vars as $key => $value)
                {
                    $$key = $value;
                }
//                ob_start();
//                $this->_content = ob_get_contents();
//                ob_end_clean();
                !$part ? $this->header(): '';
                include $viewFile;
                !$part ? $this->footer(): '';
            }
            echo $this->_content;
        } catch (Exception $e)
        {
            
        }
    }

    public function header()
    {
        $appFile = APP_PATH . DS . 'protect' . DS . 'theme' . DS . 'header.php';
        if (is_file($appFile))
        {
            include $appFile;
        }
    }

    public function footer()
    {
        $appFile = APP_PATH . DS . 'protect' . DS . 'theme' . DS . 'footer.php';
        if (is_file($appFile))
        {
            include $appFile;
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

    public function getController()
    {
        return $this->_controller;
    }

    /** 	 
     * Action setter
     * @param string $action
     */
    public function setAction($action)
    {
        $this->_action = $action;
    }

    public function getAction()
    {
        return $this->_action;
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
