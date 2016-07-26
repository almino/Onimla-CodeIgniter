<?php

namespace Onimla\CodeIgniter\SemanticUI\Message;

use Onimla\SemanticUI\Message\Error\WithWarningSign as Message;
use Onimla\SemanticUI\Form\Field;
use Onimla\HTML\Input;
use Onimla\HTML\ShortQuotation;
use Onimla\HTML\Label;

class ValidationError extends Message {

    public function __construct($field = FALSE, $id = FALSE) {
        # If it is an object
        if ($field instanceof Field OR $field instanceof Input) {
            # Get ID
            $id = $field->id()->getValue();
            # Get name
            $field = $field->name()->getValue();
        }
        
        # Get error message
        $error = trim(form_error($field, ' ', ' '));
        # To use with preg_match
        $matches = array();
        # Matches an HTML string
        #preg_match('/<([:\w\-\.\d\[\]]+)>(.*)<\/[:\w\-\.\d\[\]]+>/', $error, $matches);
        # Matches a short quotation
        preg_match('/<q>(.*)<\/q>/', $error, $matches);
        # Get data from preg_match
        list($html, $text) = $matches;
        # Where to break the error message
        $pre = strpos($error, $html);
        $pos = $pre + strlen($html);

        # Instâncias ================================================================= #
        # Creates a message
        parent::__construct(substr($error, 0, $pre));
        # Get its content
        $content = $this->content->first();
        # Create a label
        $label = new Label($id);
        # Creates a <q>
        $quote = new ShortQuotation();

        # Atributos ================================================================== #
        # Semantic UI's default hides messages inside forms. It forces showing.
        $this->container->getClassAttribute()->before('error', 'visible');

        # Árvore ===================================================================== #
        $label->text($text);

        /* -------------------------------------------------------------------------- */
        
        $content->append($quote);
        $content->appendText(substr($error, $pos));
        $quote->append($label);
    }

}
