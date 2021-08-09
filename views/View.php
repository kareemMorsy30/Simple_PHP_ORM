<?php

namespace Views;

class View
{
    private $data = array();

    private $render = FALSE;

    public function __construct($template, $variables)
    {
        try {
            $file = 'views/'.strtolower($template).'.php';

            if (file_exists($file)) {
                $this->render = $file;

                foreach($variables as $variable => $value) {
                    $this->data[$variable] = $value;
                }
            } else {
                throw new \Exception('Template ' . $template . ' not found!');
            }
        }
        catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function __destruct()
    {
        extract($this->data);
        include($this->render);
    }
}
?>