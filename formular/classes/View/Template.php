<?php
namespace View;

class Template
{
    protected $file;
    protected $templateDir;
    protected $data = array();

    public function __construct($file)
    {
        $this->file = $file;
        $this->templateDir = PROJECT_ROOT . '/templates/';
    }

    public function assign($variable, $value)
    {
        $this->data[$variable] = $value;
    }

    public function render()
    {
        if (!file_exists($this->templateDir . $this->file . '.phtml')) {
            throw new \Exception('Template file not found: ' . $this->file);
        }
        ob_start();
        extract($this->data);
        include($this->templateDir . $this->file . '.phtml');
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}