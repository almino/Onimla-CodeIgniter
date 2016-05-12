<?php

namespace Onimla\HTML;

require_once 'Element.class.php';

class Link extends Element {

    function __construct($href, $media = NULL, $type = 'text/css', $rel = 'stylesheet') {
        parent::__construct('link');
        $this->rel($rel);
        $this->type($type);
        $this->media($media);
        $this->href($href);
    }

    function charset($char_encoding = FALSE) {
        $this->attr('charset', $char_encoding);
    }

    function href($url = FALSE) {
        return $this->attr('href', $url);
    }

    function hreflang($language_code = FALSE) {
        $this->attr('hreflang', $language_code);
    }

    function media($value = NULL) {
        if (!empty($value)) {
            $this->attr('media', $value);
        }
        return $this->attr('media');
    }

    function rel($value = NULL) {
        $this->attr('rel', $value);
    }

    function rev($value = NULL) {
        $this->attr('rev', $value);
    }

    function target($frame_name = NULL) {
        $this->attr('target', $frame_name);
    }

    function type($MIME_type = NULL) {
        if (!empty($MIME_type)) {
            $this->attr('type', $MIME_type);
        }

        return $this->attr('type');
    }

}

?>