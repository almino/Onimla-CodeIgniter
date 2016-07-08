<?php

namespace Onimla\CodeIgniter\SemanticUI;

use Onimla\HTML\Node;
use Onimla\SemanticUI\Form\Field;
use Onimla\CodeIgniter\SemanticUI\Message\ValidationError;

class FieldWithValidationError extends Node {

    public function __construct(Field $field, $error = NULL) {
        parent::__construct();
        $this->field = $field;

        if ($error !== NULL) {
            $this->message = $error;
        } elseif (form_error($field->name())) {
            $this->message = new ValidationError($field);
        }
    }

}
