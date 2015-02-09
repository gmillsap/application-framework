<?php
namespace GAF;

use Input;
use Template;

class ControllerBase {
    protected $inputs;
    protected $layout;
    protected $layout_file = 'main_layout.php';
    protected $navigation;
    protected $head_scripts = array();
    protected $foot_scripts = array();
    protected $styles = array();
    protected $scripts = array();

    public function __construct() {
        $this->inputs = Input::buildFromRequest();
        $this->layout = new Layout();
        $this->template = new Template();
    }

    public function before() {
        return $this;
    }

    public function after() {
        return $this;
    }

    public function getLayout() {
        return $this->layout;
    }

    public function setLayout(Layout $layout) {
        $this->layout = $layout;
        return $this;
    }

    public function setLayoutFile($file) {
        $this->layout_file = $file;
        return $this;
    }

    public function getLayoutFile() {
        return $this->layout_file;
    }

    public function getInput($key) {
        if(isset($this->inputs[$key])) {
            return $this->inputs[$key]->getValue();
        }
        return null;
    }

    public function buildPage() {
        $this->page_content = '';
        return $this;
    }

    public function renderPage() {
        $this->includeAssets();
        $this->layout->setLayoutFile($this->layout_file);
        if ($this->template->getTemplateFile()) {
            $this->template->generateContent();
            $this->layout->setContent($this->template->getContent());
        }
        return $this->layout->render();
    }

    public function addStyle(Style $style) {
        $this->styles[] = $style;
        return $this;
    }

    public function addScript(Script $script) {
        $this->scripts[] = $script;
        return $this;
    }

    public function includeAssets() {
        $styles = $this->styles;
        foreach($styles as $style) {
            $this->layout->addStyle($style);
        }
        foreach($this->head_scripts as $script) {
            $new_script = new Script($script);
            $new_script->setInHead();
            $this->layout->addScript($new_script);
        }
        foreach($this->foot_scripts as $script) {
            $new_script = new Script($script);
            $this->layout->addScript($new_script);
        }
        $scripts = $this->scripts;
        foreach($scripts as $script) {
            $this->layout->addScript($script);
        }
    }

    public function validateInputs() {
        $this->setValidationRules();
        foreach($this->validation_rules as $rule) {
            $this->validator->addRule($rule);
        }
        return $this->validator->validate();
    }

    public function inputsAreValid() {
        return $this->validator->isValid();
    }

    public static function redirect($code, $page) {
        Redirect::withCode($code);
        $controller = new self();
        $controller->template->setTemplateDir($_SERVER['DOCUMENT_ROOT'])->setTemplateFile($page);
        $controller->render();
    }

    public function redirectWithCode($code) {
        Redirect::withCode($code);
        $this->template->setTemplateDir($_SERVER['DOCUMENT_ROOT'])->setTemplateFile('/' . $code . '.php');
        $this->render();
        return $this;
    }

    public function redirectWithError($error_code, $page, $data = array()) {
        Redirect::withCode($error_code);
        $this->template->setTemplateFile($page)
            ->setTemplateData($data);
        $this->render();
        return $this;
    }

    public function postRefreshSession() {
        $session = new Session();
        $session->refresh();
        $response = new \Response();
        return $response->addMessage(array('success' => 'Session refreshed.'))
            ->returnAsJSON();
    }
}