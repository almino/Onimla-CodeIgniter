<?php

namespace Onimla\CodeIgniter;

class Form extends \Onimla\HTML\Form {

    public function __construct($method = FALSE, $action = FALSE) {
        parent::__construct($method, $action);
        $this->prepend(new \Onimla\HTML\Hidden(get_instance()->security->get_csrf_token_name(), get_instance()->security->get_csrf_hash()));
    }

}
