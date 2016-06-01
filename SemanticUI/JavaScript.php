<?php

namespace Onimla\CodeIgniter\StyleSheet;

class JavaScript extends \Onimla\HTML\Script {

    public $baseURL = 'base_url';
    public $defaultFolder = 'semantic/dist';
    public $fileName = 'semantic';
    public $production = 'semantic.min';
    public $fileExtension = '.js';

    public function __construct() {
        $src = implode('/', array(
            rtrim(is_callable($this->baseURL) ? call_user_func($this->baseURL) : $this->baseURL, '/'),
            $this->defaultFolder,
            (ENVIROMENT == 'production' ? $this->production : $this->fileName) . $this->fileExtension,
        ));
        
        parent::__construct($src);
        $this->selfClose(FALSE);
    }

}
