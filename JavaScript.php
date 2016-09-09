<?php

namespace Onimla\CodeIgniter;

use Onimla\HTML\Script;

class JavaScript extends \Onimla\HTML\Node {

    public $baseURL = 'base_url';
    public $defaultFolder = 'js';
    public $fileExtension = '.js';

    /**
     * @var CI_Controller
     */
    protected $CI;
    public $controller;
    public $method;

    public function __construct() {
        parent::__construct();
        $this->CI = & get_instance();

        $this->indentSource = TRUE;
        $this->before = "        ";
    }

    public function __toString() {
        $this->loadFromConfigFile();
        $this->defaultFile();
        return parent::__toString() . "\n";
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
        $this->CI->load->config('js', TRUE, TRUE);

        # A pasta está definida lá?
        if ($this->CI->config->item('folder', 'js')) {
            # Aletra a pasta padrão
            $this->defaultFolder = $this->CI->config->item('folder', 'js');
        }

        # Se possui algum arquivo CSS a ser importado
        if ($this->CI->config->item($uri, 'js')) {

            $links = new \Onimla\HTML\Node();

            # Percorre todos os arquivos
            foreach ($this->CI->config->item($uri, 'js') as $file) {
                # Caminho até o arquivo, a partir da raiz do projeto
                $filepath = implode(DIRECTORY_SEPARATOR, array(
                    $this->defaultFolder,
                    $file,
                ));

                # Coloca a extensão do arquivo, caso não tenha sido informada 
                if (!strstr($filepath, $this->fileExtension)) {
                    $production = "{$filepath}.min{$this->fileExtension}";
                    $filepath .= $this->fileExtension;
                }

                /*
                  var_dump(FCPATH);
                  var_dump($filepath);
                 */

                if (defined('ENVIRONMENT') AND ENVIRONMENT == 'production' AND file_exists(FCPATH . $production)) {
                    $links->append(new Script((is_callable($this->baseURL) ? call_user_func($this->baseURL) : $this->baseURL) . $production));
                } elseif (file_exists(FCPATH . $filepath)) {
                    # Verifica se o arquivo existe
                    $links->append(new Script((is_callable($this->baseURL) ? call_user_func($this->baseURL) : $this->baseURL) . $filepath));
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

        $link = new Script((is_callable($this->baseURL) ? call_user_func($this->baseURL) : $this->baseURL) . $filepath);

        $this->append($link);

        return $link;
    }

}
