<?php
namespace GAF;
use Asset\Style;
use Asset\Script;

class Layout extends Template
{
    protected $styles = array();
    protected $scripts = array();
    protected $page_title;

    public function __construct() {
        parent::__construct();
        $this->layout_dir = $_SERVER['DOCUMENT_ROOT'] . '/app/templates/layouts/';
    }

    public function addStyle(Style $style, $index = null) {
        if (!is_null($index)) {
            $this->styles[$index] = $style;
        } else {
            $this->styles[] = $style;
        }
        return $this;
    }

    public function includeStyles() {
        echo "\n";
        foreach ($this->styles as $style) {
            $style->renderTag();
            echo "\n";
        }
    }

    public function addScript(Script $script, $index = null) {
        if (!is_null($index)) {
            $this->scripts[$index] = $script;
        } else {
            $this->scripts[] = $script;
        }
        return $this;
    }

    public function includeHeadScripts() {
        echo "\n";
        foreach ($this->scripts as $script) {
            if ($script->isHeadScript()) {
                $script->renderTag();
                echo "\n";
            }
        }
    }

    public function includeFootScripts() {
        echo "\n";
        foreach ($this->scripts as $script) {
            if (!$script->isHeadScript()) {
                $script->renderJavascript();
                echo "\n";
            }
        }
    }

    public function setPageTitle($title) {
        $this->page_title = $title;
        return $this;
    }

    public function setTemplateData(array $data) {
        $data['page_title'] = $this->page_title;
        parent::setTemplateData($data);
    }

}
