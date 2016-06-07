<?php

namespace Onimla\CodeIgniter\SemanticUI;

class Form extends \Onimla\SemanticUI\Form\Form {

    protected $CI;
    protected $rules;
    protected $values = array();

    public function _construct($rules = '', $method = 'post') {
        parent::__construct($method);
        $this->CI = & get_instance();

        $this->setValidationRules($rules);
    }

    public function setValidationRules($rules) {
        # Se nenhuma regra foi repassada
        if (empty($rules)) {
            # Segue o padrão do CI: pega as regras definidas para a URL
            $rules = trim($this->CI->uri->ruri_string(), '/');
        }

        # Se não são as regras propriamente ditas
        if (!is_array($rules)) {
            # Carrega as regras do arquivo de validação
            $this->CI->load->config('form_validation');
            # Pega as regras
            $rules = $this->CI->config->item($rules);
        }

        $this->rules = $rules;
    }

    protected function getFieldData($name) {
        $pos = array_search($name, array_column($this->rules, 'field'));

        # Se o campo não existe
        if ($pos === FALSE) {
            return FALSE;
        }

        return $this->rules[$pos];
    }

    /**
     * @param string $name
     * @param string $default
     * @return \Onimla\HTML\Node
     */
    public function &getTextInput($name, $default = FALSE) {
        $this->CI->load->helper(array('form'));

        if (!empty($this->children) AND key_exists($name, $this->children)) {
            return $this->children[$name];
        }

        extract($this->getFieldData($name));

        $field = new \Onimla\SemanticUI\Form\Field($label, $name, $default);
        $input = $field->input;

        # ============================================================================ #
        # Validation Rules
        # ============================================================================ #
        foreach (is_array($rules) ? $rules : explode('|', $rules) as $rule) {
            $matches = array();
            # No caso de alguma regra ter parâmetro
            if (is_string($rule) AND preg_match("/(.*?)\[(.*)\]/", $rule, $matches)) {
                $rule = $matches[1];
                $param = $matches[2];
            }

            switch ($rule) {
                case 'required':
                    $input->isRequired();
                    break;
                case 'max_length':
                case 'exact_length':
                    $input->attr('maxlength', $param);
                    break;
                case 'greater_than':
                    $input->attr('type', 'number');
                    $input->attr('min', $param + 1);
                    break;
                case 'less_than':
                    $input->attr('type', 'number');
                    $input->attr('max', $param - 1);
                    break;
                case 'numeric':
                case 'integer':
                    $input->attr('type', 'number');
                    break;
                case 'is_natural':
                    $input->attr('type', 'number');
                    $input->attr('min', '0');
                    break;
                case 'is_natural_no_zero':
                    $input->attr('type', 'number');
                    $input->attr('min', '1');
                    break;
                case 'valid_email':
                    $input->attr('type', 'email');
                    break;
                case 'valid_date':
                case 'valid_date_brazil':
                    $input->attr('type', 'date');
                    break;
                case 'valid_time':
                    $input->attr('type', 'time');
                    break;
                case 'url':
                    $input->attr('type', 'url');
                    break;
                default :
                    continue;
            }
        }

        ## ========================================================================== ##
        ## Value
        ## ========================================================================== ##
        log_section_header("Valor padrão do campo `{$field}`", 'debug');
        log_debug("`set_value()` : " . var_to_log(set_value($field)));
        log_debug('`' . get_class($input) . '::value()` : ' . var_to_log($input->value()));
        log_debug(__CLASS__ . "::values['{$field}']` = " . (key_exists($field, $this->values) ? var_to_log($this->values[$field]) : 'none'));
        log_debug("`\$default` = " . var_to_log($default));

        # Pega o valor padrão definido pelo CodeIgniter
        $input->value(set_value($field));

        # Verifica se NÃO há um valor no campo
        if ($input->value() === FALSE OR strlen($input->value()) < 1) {
            log_debug("Nenhum valor no campo `{$field}`.");

            # Se o valor padrão passado para o método for NULO
            if ($default === NULL) {
                log_debug("O valor padrão passado para o método `" . __METHOD__ . "` é `NULL`.");
                log_debug("Removendo o valor do campo `{$field}`.");
                # Remove o valor do campo
                $input->removeAttr('value');
                # Se vier algum valor padrão
            } elseif ($default !== FALSE AND strlen($default) > 0) {
                log_debug("O valor padrão passado para o método `" . __METHOD__ . "` é VÁLIDO.");
                log_debug("Redefinindo o valor do campo `{$field}` para '{$default}'.");
                # Redefine o valor padrão do campo
                $input->value($default);
            }

            # Se existir na variável com os valores padrão
            if (key_exists($field, $this->values)) {
                log_debug("Alterando o valor do campo `{$field}` para o existente em "
                        . __CLASS__ . "::values['{$field}']`.");
                # Define o valor padrão
                $input->value($this->values[$field]);
            } else {
                log_debug("Não existe valor padrão em `"
                        . __CLASS__ . "::values['{$field}']`.");
            }
        } else {
            log_debug("O campo `{$field}` já possuía um valor.");
        }

        log_section_footer('debug');

        ## ========================================================================== ##
        ## Error
        ## ========================================================================== ##
        if (form_error($name)) {
            # Instâncias ================================================================= #
            $message = new \Onimla\SemanticUI\Message(form_error($name));
            
            # Atributos ================================================================== #
            $message->error();
            $field->error();
            
            # Árvore ===================================================================== #
            $message->icon(new \Onimla\SemanticUI\Icon\WarningSign());
            
            # Exibição =================================================================== #
            $field->append($message);
        }
        

        $this->children[$name] = $field;

        return $this->children[$name];
    }

    /**
     * 
     * @param string $name
     * @param string $default
     * @return \Onimla\HTML\Label
     */
    public function &getBoolCheckbox($name, $default = FALSE) {
        if (!empty($this->children) AND key_exists($name, $this->children)) {
            return $this->children[$name];
        }

        $field = $this->getFieldData($name);
        unset($field['rules']);
        extract($field);

        # Instâncias ================================================================= #
        $checkbox = new \Onimla\HTML\Checkbox($name, 1);
        $hidden = new \OOHTML\Hidden($name, 0);
        $label = new \Onimla\HTML\Label($checkbox, $label);

        # Atributos ================================================================== #
        # Árvore ===================================================================== #
        $label->hidden = $hidden;
        $label->checkbox = $checkbox;

        if (key_exists($name, $this->values)) {
            $this->values[$name] ? $checkbox->check() : $checkbox->uncheck();
        }

        if ($default !== FALSE) {
            $default ? $checkbox->check() : $checkbox->uncheck();
        }

        if (set_checkbox($checkbox->name(), 1) !== '') {
            $checkbox->check();
        }

        if (set_checkbox($checkbox->name(), 0) !== '') {
            $checkbox->uncheck();
        }

        return $label;
    }

    /**
     * @param string $name
     * @param array $options
     * @param string $default
     * @return \Onimla\HTML\Node
     */
    public function &getDropdown($name, $options = array(), $default = FALSE) {
        if (!empty($this->children) AND key_exists($name, $this->children)) {
            return $this->children[$name];
        }

        # Instâncias ================================================================= #
        $group = $this->getTextInput($name, $default);
        $select = new \Onimla\HTML\Select($group->name(), $options);
        $disabled = new \Onimla\HTML\Option(0, 'Selecione…');

        # Atributos ================================================================== #
        $disabled->select();
        $disabled->disable();

        if (key_exists($name, $this->values) AND $default === FALSE) {
            $default = $this->values[$name];
        }

        if (strlen(set_value($group->name())) > 0 OR set_value($group->name()) > 0) {
            $default = set_value($group->name());
        }

        foreach ($options as $option) {
            /* @var $option \OOHTML\Option */
            if ($option->value() == $default) {
                $select->deselectAll();
                $disabled->deselect();
                $option->select();
                break;
            }
        }

        # Árvore ===================================================================== #
        $group->container()->removeChild($group->control());
        $group->control($select);

        $select->prepend($disabled);

        # Exibição =================================================================== #
        return $group;
    }

    public function getValues() {
        return $this->values;
    }

    public function parseValues() {
        $values = array();
        $pieces = array();

        foreach ($this->getValues() as $key => $val) {
            $pieces[] = "{$key}=" . urlencode($val);
        }

        /*
          var_dump($pieces);
          var_dump(implode('&', $pieces));
         */

        parse_str(implode('&', $pieces), $values);

        #var_dump($values);

        return $values;
    }

    public function setValues($values) {
        #log_var($values);
        # Verifica se veio algum valor
        if (is_array($values) AND count($values) > 0) {
            # Coloca na variável para uso em outro método
            $this->values = $values;

            # Para cada valor no array
            foreach ($values as $field => $value) {
                # Verifica se o campo existe
                if (count($this->children) > 0
                        AND key_exists($field, $this->children)
                        AND property_exists($this->children[$field], 'control')
                        AND is_callable(array($this->children[$field]->control, 'value'))) {
                    $this->children[$field]->control->value($value);
                }
            }

            return $this;
        }

        return FALSE;
    }

    public function exists($field) {
        return !empty($this->children) AND key_exists($field, $this->children);
    }

}
