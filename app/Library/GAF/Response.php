<?php
namespace GAF;

class Response
{
    protected static $responses = array(
        100 => '100 Continue',
        101 => '101 Switching Protocols',
        200 => '200 OK',
        201 => '201 Created',
        202 => '202 Accepted',
        203 => '203 Non-Authoritative Information',
        204 => '204 No Content',
        205 => '205 Reset Content',
        206 => '206 Partial Content',
        300 => '300 Multiple Choices',
        301 => '301 Moved Permanently',
        302 => '302 Found',
        303 => '303 See Other',
        304 => '304 Not Modified',
        305 => '305 Use Proxy',
        307 => '307 Temporary Redirect',
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        402 => '402 Payment Required',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        405 => '405 Method Not Allowed',
        406 => '406 Not Acceptable',
        407 => '407 Proxy Authentication Required',
        408 => '408 Request Time-out',
        409 => '409 Conflict',
        410 => '410 Gone',
        411 => '411 Length Required',
        412 => '412 Precondition Failed',
        413 => '413 Request Entity Too Large',
        414 => '414 Request-URI Too Large',
        415 => '415 Unsupported Media Type',
        416 => '416 Requested Range Not Satisfiable',
        417 => '417 Expectation Failed',
        500 => '500 Internal Server Error',
        501 => '501 Not Implemented',
        502 => '502 Bad Gateway',
        503 => '503 Service Unavailable',
        504 => '504 Gateway Time-out',
        505 => '505 HTTP Version Not Supported'
    );
    protected $response_code = 200;
    protected $response_details;
    protected $messages = array();
    
    public function setResponseCode($code) {
        $codes = array_keys(self::$responses);
        if (!in_array($code, $codes)) {
            return false;
        }
        $this->response_code = $code;
        $this->response_details = self::$responses[$code];
        return $this;
    }
    
    public function setMessages(array $messages) {
        $this->messages = $messages;
        return $this;
    }
    
    public function addMessage($message) {
        if ((array)$message === $message) {
            foreach ($message as $k => $v) {
                $this->messages[$k] = $v;
            }
        } else {
            $this->messages[] = $message;
        }
        return $this;
    }
    
    public function getMessages() {
        return $this->messages;
    }
    
    public function returnAsJSON() {
        $this->setHTTPResponseCode();
        echo json_encode($this->messages);
        return;
    }
    
    public function setHTTPResponseCode($code = null) {
        if (is_null($code)) {
            $code = $this->response_code;
        }
        http_response_code($code);
        return $this;
    }

    public static function getHTTPResponseHeader($code) {
        return $_SERVER['SERVER_PROTOCOL'] . ' ' . self::$responses[$code];
    }
}