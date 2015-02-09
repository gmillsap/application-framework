<?php
namespace GAF\Asset;

class Script implements AssetInterface
{
    protected $path;
    protected $in_head = false;
    protected $attributes = array();
    protected $type = 'text/javascript';
    
    public function __construct($path = null) {
        if (!is_null($path)) {
            $this->path = $path;
        }
    }
    
    public function setPath($path) {
        $this->path = $path;
        return $this;
    }
    
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function addAttribute($attr, $val) {
        $this->attributes[$attr] = $val;
        return $this;
    }
    
    public function setInHead($in_head = true) {
        $this->in_head = $in_head;
    }

    public function renderTag() {
        $tag = '        '; //assumed 2 tab indention 
        $tag .= '<script src="' . $this->path . '" ';
        $tag .= 'type="' . $this->type . '" ';
        foreach($this->attributes as $key => $val) {
            $tag .= $key . '="' . $val . '" ';
        }
        $tag .= '></script>';
        echo $tag;
    }

    public function renderJavascript() {
        $javascript = '<script type="' . $this->type . '"';
        foreach($this->attributes as $key => $val) {
            $javascript .= $key . '="' . $val . '" ';
        }
        $javascript .= '>' . "\n";
        ob_start();
            include(SITE_LOC . $this->path);
            $javascript .= ob_get_contents();
        ob_end_clean();
        $javascript .= "\n" . '</script>';
        echo $javascript;
    }

    public function isHeadScript() {
        return $this->in_head;
    }
}
