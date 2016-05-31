<?php

namespace Onimla\HTML;

require_once 'Element.class.php';

class Link extends Element {

    function __construct($href, $media = FALSE, $type = 'text/css', $rel = 'stylesheet') {
        parent::__construct('link');
        $this->rel($rel);
        $this->type($type);
        $this->media($media);
        $this->href($href);
    }

    function charset($charEncoding = FALSE) {
        return $this->attr('charset', $charEncoding);
    }

    function href($url = FALSE) {
        return $this->attr('href', str_replace('\\', '/', $url));
    }

    function hrefLang($languageCode = FALSE) {
        return $this->attr('hreflang', $languageCode);
    }

    function media($value = FALSE) {
        return $this->attr('media', $value);
    }

    function rel($value = FALSE) {
        return $this->attr('rel', $value);
    }

    function rev($value = FALSE) {
        return $this->attr('rev', $value);
    }

    function target($frameName = FALSE) {
        return $this->attr('target', $frameName);
    }

    function type($MIMEType = FALSE) {
        return $this->attr('type', $MIMEType);
    }

}
