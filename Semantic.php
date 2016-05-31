<?php

namespace Onimla\CodeIgniter;

class Semantic extends \Onimla\HTML\Node {

    public $baseURL = 'base_url';
    public $defaultFolder = 'semantic/dist';
    public $fileName = 'semantic';
    public $production = 'semantic.min';
    public $cssExtension = '.css';
    public $jsExtension = '.js';

    public function __construct() {
        parent::__construct();
    }

    public function css($stylesheet = FALSE) {
        if ($stylesheet instanceof \Onimla\HTML\Link) {
            $this->css = $stylesheet;
        }

        if ($stylesheet === FALSE) {
            $this->css = new \Onimla\HTML\Link(implode('/', array(
                        rtrim(is_callable($this->baseURL) ? call_user_func($this->baseURL) : $this->baseURL, '/'),
                        $this->defaultFolder,
                        (ENVIROMENT == 'production' ? $this->production : $this->fileName) . $this->cssExtension,
            )));
        }

        if (!isset($this->css)) {
            return FALSE;
        }

        return $this->css;
    }

}
