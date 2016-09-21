<?php

namespace Onimla\CodeIgniter\Traits;

trait MinifiedFile {

    /**
     * Checks for a minified version of the file and return the file path
     * @param string $filepath
     * @return string
     */
    public function minifiedFile($filepath) {
        $production = $filepath;

        if (strpos($filepath, '.min') === FALSE) {
            $pos = strpos($filepath, $this->fileExtension);
            $production = substr($filepath, 0, $pos)
                    . '.min'
                    . $this->fileExtension;
        }

        if (defined('ENVIRONMENT') AND ENVIRONMENT != 'development' AND file_exists(FCPATH . $production)) {
            return $production;
        }

        return $filepath;
    }

}
