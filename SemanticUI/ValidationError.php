<?php

namespace Onimla\CodeIgniter\SemanticUI;

use Onimla\SemanticUI\Message;
use Onimla\SemanticUI\Form\Field;
use Onimla\HTML\Input;
use Onimla\HTML\ShortQuotation;
use Onimla\HTML\Label;
# Modify the icon shown for these messages
use Onimla\SemanticUI\Icon\WarningSign as Icon;

class ValidationError extends Message {

    public function __construct($field = FALSE, $id = FALSE) {
        # If it is an object
        if ($field instanceof Field OR $field instanceof Input) {
            # Get ID
            $id = $field->id();
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
        # This is an error message
        $this->error();
        # Semantic UI's default hides messages inside forms. It forces showing.
        $this->container->getClassAttribute()->after(\Onimla\SemanticUI\Component::CLASS_NAME, 'visible');

        # Árvore ===================================================================== #
        $label->text($text);

        /* -------------------------------------------------------------------------- */
        
        $content->append($quote);
        $content->appendText(substr($error, $pos));
        $quote->append($label);

        /* -------------------------------------------------------------------------- */

        # Sets the icon
        $this->icon(new Icon);
    }

}
