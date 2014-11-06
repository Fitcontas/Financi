<?php

namespace Financi;

use Symfony\Component\Yaml\Yaml;

class View extends \Slim\View {
	
	/**
     * Render a template file
     *
     * NOTE: This method should be overridden by custom view subclasses
     *
     * @param  string $template     The template pathname, relative to the template base directory
     * @param  array  $data         Any additonal data to be passed to the template.
     * @return string               The rendered template
     * @throws \RuntimeException    If resolved template pathname is not a valid file
     */
    protected function render($template, $data = null)
    {
        $view_config = Yaml::parse( APP_CONFIG_PATH . DS . 'view.yml' );
        $default = $view_config['default'];

    	//Pegando as variáveis passados a view
    	$data = array_merge($this->data->all(), (array) $data);

        $data['title'] = isset($data['title']) ? $data['title'] : $default['title'];

    	//definido o nome do layout
    	$layout_name = isset($data['layout']) ? $data['layout'] : 'index.php';

    	//path do layout
        $layout = APP_PATH . DS . 'templates' . DS . $layout_name;

        //path do template
        $templatePathname = $this->getTemplatePathname($template);
        
        if (!is_file($layout)) {
            throw new \RuntimeException("View cannot render `$layout` because the layout does not exist");
        }

        if (!is_file($templatePathname)) {	
            throw new \RuntimeException("View cannot render `$template` because the template does not exist");
        }
        
        $data['content'] = $templatePathname;
        
        $data['head_css'] =  isset($data['head_css']) ? array_merge($this->getDefaultCss(), $data['head_css']) : $this->getDefaultCss();
        
        $data['head_js'] =  isset($data['head_js']) ? array_merge($this->getDefaultJs(), $data['head_js']) : $this->getDefaultJs();

        $data['foot_css'] =  isset($data['foot_css']) ? $data['foot_css'] : [];

        $data['foot_js'] =  isset($data['foot_js']) ? $data['foot_js'] : [];

        $data['layout'] = $layout;
        $data['app'] = $this;
        $data['user'] = \Financi\Auth::getUser();
        $data['flash'] =  new \Financi\Flash();

        extract($data);
        ob_start();
        require $layout;

        return ob_get_clean();
    }

    public function getDefaultCss() 
    {

        $css = [];

        $view_default_config = Yaml::parse( APP_CONFIG_PATH . DS . 'view.yml' );

        $view_default_css = isset($view_default_config['default']['stylesheets']) ? $view_default_config['default']['stylesheets'] : [];

        foreach($view_default_css as $key => $value) {
            
            if(is_array($value)) {
                
                foreach ($value as $key2 => $value2) {
                    if($this->isDefaultCssFile($key2)) {
                        $css['css' . DS . $key2 . '.css'] = [ 'media' => $value2['media'] ];
                    } else {
                        $css[$key2 . '.css'] = [ 'media' => $value2['media'] ];
                    }
                }
                
            } else {

                if($this->isDefaultCssFile($value)) {
                    $css[] = 'css' . DS . $value . '.css';
                } else {
                    $css[] = $value . '.css';
                }

            }

        }

        return $css;
    }

    public function getDefaultJs() 
    {

        $js = [];

        $view_default_config = Yaml::parse( APP_CONFIG_PATH . DS . 'view.yml' );

        $view_default_js = isset($view_default_config['default']['javascripts']) ? $view_default_config['default']['javascripts'] : [];

        foreach($view_default_js as $key => $value) {
            if($this->isDefaultCssFile($value)) {
                $js[] = 'js' . DS . $value . '.js';
            } else {
                $js[] = $value . '.js';
            }
        }

        return $js;
    }

    /**
     * Verificar se o arquivo está dentro da pasta padrão de css, /css
     */
    public function isDefaultCssFile($name, $type = 'css/') {
        $string = substr($name, 0, 4);
        $explode = explode("/", $name);

        if($string == $type) {
            return true;
        }

        if(count($explode) == 1) {
            return true;
        }
        return false;
    }

}