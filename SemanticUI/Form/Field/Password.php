<?php

namespace Onimla\CodeIgniter\SemanticUI\Form\Field;

use Onimla\SemanticUI\Form\Field\Password as BaseField;

class Password extends BaseField {

    public function __toString() {
        if (form_error($this->name())) {
            $this->error();
        }

        return parent::__toString();
    }

}
