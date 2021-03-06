<?php

namespace Onimla\CodeIgniter\SemanticUI\Form;

use Onimla\SemanticUI\Form\Field as BaseField;

class Field extends BaseField {

    public function __toString() {
        if (!$this->container->hasClass('error') AND form_error($this->name())) {
            $this->error();
        }

        return parent::__toString();
    }

}
