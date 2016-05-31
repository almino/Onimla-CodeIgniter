<?php

namespace Onimla\CodeIgniter;

class Style extends \Onimla\HTML\Node {

    public $baseURL = 'base_url';
    public $defaultFolder = 'css';
    public $fileExtension = '.css';

    /**
     * @var CI_Controller
     */
    protected $CI;
    public $controller;
    public $method;

    public function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
        
        $this->after = "\n";
    }

    public function __toString() {
        $this->loadFromConfigFile();
        $this->defaultFile();
        return parent::__toString();
    }

    public function init() {
        if (empty($this->controller)) {
            $this->controller = $this->CI->router->class;
        }

        if (empty($this->method)) {
            $this->method = $this->CI->router->method;
        }
    }

    public function loadFromConfigFile() {
        # Inicia as variáveis
        $this->init();

        # URI atual, index do array em config/css.php
        $uri = implode('/', array(
            $this->controller,
            $this->method,
        ));

        # Carrega as configurações
        $this->CI->load->config('css', TRUE, TRUE);

        # A pasta está definida lá?
        if ($this->CI->config->item('folder', 'css')) {
            # Aletra a pasta padrão
            $this->defaultFolder = $this->CI->config->item('folder', 'css');
        }

        # Se possui algum arquivo CSS a ser importado
        if ($this->CI->config->item($uri, 'css')) {

            $links = new \Onimla\HTML\Node();

            # Percorre todos os arquivos
            foreach ($this->CI->config->item($uri, 'css') as $file) {
                # Caminho até o arquivo, a partir da raiz do projeto
                $filepath = implode(DIRECTORY_SEPARATOR, array(
                    $this->defaultFolder,
                    $file,
                ));

                # Coloca a extensão do arquivo, caso não tenha sido informada 
                if (!strstr($filepath, $this->fileExtension)) {
                    $filepath .= $this->fileExtension;
                }

                /*
                  var_dump(FCPATH);
                  var_dump($filepath);
                 */

                # Verifica se o arquivo existe
                if (file_exists(FCPATH . $filepath)) {
                    $links->append(new \Onimla\HTML\Link(is_callable($this->baseURL) ? call_user_func($this->baseURL) : $this->baseURL . $filepath));
                }
            }

            $this->merge($links);

            return $links;
        }

        return FALSE;
    }

    /**
     * 
     * @return boolean|\Onimla\HTML\Link
     */
    public function defaultFile() {
        $filepath = implode(DIRECTORY_SEPARATOR, array(
            $this->defaultFolder,
            $this->controller,
            $this->method,
        ));

        if (strpos($filepath, $this->fileExtension) === FALSE) {
            $filepath .= $this->fileExtension;
        }

        if (!file_exists(FCPATH . $filepath)) {
            return FALSE;
        }

        if (ENVIRONMENT == 'development') {
            $filepath .= '?dev=' . uniqid();
        }

        $this->log('$filepath = ' . $filepath);

        $link = new \Onimla\HTML\Link(is_callable($this->baseURL) ? call_user_func($this->baseURL) : $this->baseURL . $filepath);

        $this->append($link);

        return $link;
    }

}
