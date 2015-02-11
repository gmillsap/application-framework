<?php
namespace Controller;

class Root extends ControllerBase
{
    public function getIndex() {
        $this->template->setTemplateFile('root/home_page.php');
        $this->renderPage();
    }
}
