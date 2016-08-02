<?php

namespace Onimla\CodeIgniter\SemanticUI\Menu;

use Onimla\SemanticUI\Menu\Item as BaseItem;
use stdClass;

class Item extends BaseItem {

    protected $ignoreSegment = 4;

    public function __construct($text = FALSE, $href = FALSE, $title = FALSE) {
        parent::__construct($text, $href, $title);

        if (function_exists('current_url') AND current_url() == $href) {
            $this->setActive();
        } elseif ($this->ignoreSegment > 0 AND function_exists('site_url') AND function_exists('current_url')) {
            $segments = new stdClass();
            $segments->current = array_slice(explode('/', trim(substr(current_url(), strlen(site_url())), '/')), 0, $this->ignoreSegment - 1);
            $segments->href = array_slice(explode('/', trim(substr($href, strlen(site_url())), '/')), 0, $this->ignoreSegment - 1);

            if (implode('/', $segments->current) == implode('/', $segments->href)) {
                $this->setActive();
            }
        }
    }

}
