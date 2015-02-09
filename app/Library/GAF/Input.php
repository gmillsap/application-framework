<?php
namespace GAF;

class Input
{
    protected $type;
    protected $key = '';
    protected $value = '';

    public function __toString() {
        return $this->value;
    }


    public function setKey($key) {
        $this->key = $key;
        return $this;
    }

    public function getKey() {
        return $this->key;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function getType() {
        return $this->type;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

    public static function buildFromRequest() {
        $inputs = array();
        $posts = self::buildInputsFromArray($_POST, 'POST');
        foreach($posts as $post) {
            $inputs[$post->getKey()] = $post;
        }
        $gets = self::buildInputsFromArray($_GET, 'GET');
        foreach($gets as $get) {
            $inputs[$get->getKey()] = $get;
        }
        return $inputs;
    }

    protected static function buildInputsFromArray(array $array, $type) {
        $inputs = array();
        foreach($array as $key => $value) {
            $input = new self();
            $input->setKey($key)
                ->setType($type)
                ->setValue($value);
            $inputs[] = $input;
        }
        return $inputs;
    }
}