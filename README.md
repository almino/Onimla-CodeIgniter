You can extends this class and create methods for each field.

# Example
`config/form_validation.php`:
```php
$config['usuario'] = array(
    array(
        'field' => 'usuario',
        'label' => 'Endereço de e-mail',
        'rules' => implode('|', array(
            'trim',
            'required',
            'mb_strtolower',
            'valid_email',
        )),
    ),
    array(
        'field' => 'senha',
        'label' => 'Senha',
        'rules' => implode('|', array(
            'trim',
            'required',
            'exact_length[128]',
        )),
    ),
);
```

`view/login.php`:
```php
# Like Java's import
use Onimla\CodeIgniter\SemanticUI\Form;

# Load validation rules into the class
$usuario = new Form('usuario');

# Generate fields
$usuario->getTextInput('usuario');
$usuario->getTextInput('senha');

# Prints HTML
echo $usuario;
```
## Output
```html
<form method="post" class="ui form">
  <input type="hidden" name="csrf_test_name" value="/*-/*-/*-/*-/*-/*-/*-/*-/*-/*-/*" />
  <div class="required field">
    <label for="579a7cf820701">Endere&ccedil;o de e-mail</label>
    <input type="email" name="usuario" id="579a7cf820701" required value />
  </div>
  <div class="required field">
    <label for="579a7cf8213b4">Senha</label>
    <input type="text" name="senha" id="579a7cf8213b4" required maxlength="128" value />
  </div>
</form>
```
