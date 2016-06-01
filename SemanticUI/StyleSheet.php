<?php

namespace Onimla\CodeIgniter;

class StyleSheet extends \Onimla\HTML\Link {

    public $baseURL = 'base_url';
    public $defaultFolder = 'semantic/dist';
    public $fileName = 'semantic';
    public $production = 'semantic.min';
    public $cssExtension = '.css';
    public $jsExtension = '.js';

    public function __construct() {
        $href = implode('/', array(
            rtrim(is_callable($this->baseURL) ? call_user_func($this->baseURL) : $this->baseURL, '/'),
            $this->defaultFolder,
            (ENVIROMENT == 'production' ? $this->production : $this->fileName) . $this->cssExtension,
        ));
        
        parent::__construct($href);
    }

}
