<?php
namespace GAF\Asset;

class Style implements AssetInterface
{
    protected $path;
    protected $type = 'text/css';
    protected $rel = 'styleSheet';
    protected $attributes = array();
    
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
    
    public function setRel($rel) {
        $this->rel = $rel;
        return $this;
    }
    
    public function setAttributes(array $attrs) {
        $this->attributes = $attrs;
        return $this;
    }
    
    public function addAttribute($attr) {
        $this->attributes[] = $attr;
        return $this;
    }
    
    public function getAttributes() {
        return $this->attributes;
    }
    
    public function renderTag() {
        $tag = '<link href="' . $this->path . '" ';
        $tag .= 'rel="' . $this->rel . '" ';
        $tag .= 'type="' . $this->type . '" ';
        foreach($this->attributes as $key => $val) {
            $tag .= $key . '="' . $val . '" ';
        }
        $tag .= '/>';
        echo $tag;
    }
}
