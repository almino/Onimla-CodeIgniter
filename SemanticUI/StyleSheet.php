<?php

namespace Onimla\CodeIgniter\SemanticUI;

class StyleSheet extends \Onimla\HTML\Link {

    public $baseURL = 'base_url';
    public $defaultFolder = 'semantic/dist';
    public $fileName = 'semantic';
    public $production = 'semantic.min';
    public $fileExtension = '.css';

    public function __construct() {
        $href = implode('/', array(
            rtrim(is_callable($this->baseURL) ? call_user_func($this->baseURL) : $this->baseURL, '/'),
            $this->defaultFolder,
            (ENVIRONMENT != 'development' ? $this->production : $this->fileName) . $this->fileExtension,
        ));
        
        parent::__construct($href);
    }

}
