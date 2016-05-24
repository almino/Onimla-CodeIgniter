<?php

namespace Onimla\HTML;

require_once 'Attribute.class.php';

#var_dump(substr(__DIR__, 0, strpos(__DIR__, 'Onimla') + 12));

#require_once substr(__DIR__, 0, strpos(__DIR__, 'OOHTML')) . 'OOHTML/Attribute/AccessKey.class.php';
#require_once substr(__DIR__, 0, strpos(__DIR__, 'Onimla' + 10)) . 'OOHTML/Attribute/Klass.class.php';
#require_once substr(__DIR__, 0, strpos(__DIR__, 'OOHTML')) . 'OOHTML/Attribute/ContentEditable.class.php';
#require_once substr(__DIR__, 0, strpos(__DIR__, 'OOHTML')) . 'OOHTML/Attribute/ContextMenu.class.php';
#require_once substr(__DIR__, 0, strpos(__DIR__, 'OOHTML')) . 'OOHTML/Attribute/Data.class.php';
#require_once substr(__DIR__, 0, strpos(__DIR__, 'OOHTML')) . 'OOHTML/Attribute/Dir.class.php';
#require_once substr(__DIR__, 0, strpos(__DIR__, 'OOHTML')) . 'OOHTML/Attribute/Draggable.class.php';
#require_once substr(__DIR__, 0, strpos(__DIR__, 'OOHTML')) . 'OOHTML/Attribute/Dropzone.class.php';
#require_once substr(__DIR__, 0, strpos(__DIR__, 'OOHTML')) . 'OOHTML/Attribute/Hidden.class.php';
#require_once substr(__DIR__, 0, strpos(__DIR__, 'OOHTML')) . 'OOHTML/Attribute/Identifier.class.php';
#require_once substr(__DIR__, 0, strpos(__DIR__, 'OOHTML')) . 'OOHTML/Attribute/Language.class.php';
#require_once substr(__DIR__, 0, strpos(__DIR__, 'OOHTML')) . 'OOHTML/Attribute/SpellCheck.class.php';
#require_once substr(__DIR__, 0, strpos(__DIR__, 'OOHTML')) . 'OOHTML/Attribute/Style.class.php';
#require_once substr(__DIR__, 0, strpos(__DIR__, 'OOHTML')) . 'OOHTML/Attribute/TabbingIndex.class.php';
#require_once substr(__DIR__, 0, strpos(__DIR__, 'OOHTML')) . 'OOHTML/Attribute/Title.class.php';
#require_once substr(__DIR__, 0, strpos(__DIR__, 'OOHTML')) . 'OOHTML/Attribute/Translate.class.php';

require_once implode(DIRECTORY_SEPARATOR, array(__DIR__, 'Attribute', 'Klass.class.php'));
require_once implode(DIRECTORY_SEPARATOR, array(__DIR__, 'Attribute', 'Data.class.php'));
require_once implode(DIRECTORY_SEPARATOR, array(__DIR__, 'Attribute', 'Style.class.php'));

/**
 * Attributes for an HTML element.
 *
 * @author AlminoMelo at gmail.com
 */
interface HasAttribute {

    public function attr($name, $value = FALSE, $output = FALSE);

    public function matchAttr($name, $regex, $level = FALSE);

    public function &findByAttr($attr, $value);

    public function &findByName($value);

    public function &findById($value);
    
    public function matchClass($classes, $level = FALSE);
}
