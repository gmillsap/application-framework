<?php
namespace GAF;

class Template
{
    protected $template_dir;
    protected $template_file;
    protected $template_data = array();
    protected $content;

    public function __construct($file = null) {
        if (!is_null($file)) {
            $this->template_file = $file;
        }
        $this->template_dir = $_SERVER['DOCUMENT_ROOT'] . '/app/templates/';
    }

    public function __toString() {
        return $this->render();
    }

    public function setTemplateDir($template_dir) {
        $this->template_dir = $template_dir;
        return $this;
    }

    public function setTemplateFile($file) {
        $this->template_file = $file;
        return $this;
    }

    public function getTemplateFile() {
        return $this->template_file;
    }

    public function setTemplateData(array $data) {
        $this->template_data = $data;
        return $this;
    }

    public function getTemplateData() {
        return $this->template_data;
    }

    public function addTemplateData(array $data) {
        foreach($data as $key => $value) {
            $this->template_data[$key] = $value;
        }
        return $this;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function addContent($content) {
        $this->content .= $content;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function generateContent() {
        ob_start();
        extract($this->template_data);
        if(is_file($this->template_dir . $this->template_file)) {
            include($this->template_dir . $this->template_file);
        }
        $this->content = ob_get_contents();
        ob_end_clean();
        return $this;
    }

    public function render() {
        $this->generateContent();
        return $this->content;
    }

    public static function generateFromFile($file, $data = array()) {
        $template = new self($file);
        $template->setTemplateData($data);
        $template->generateContent();
        return $template;
    }
}