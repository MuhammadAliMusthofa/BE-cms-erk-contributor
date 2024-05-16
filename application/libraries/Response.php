<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Response {

    protected $CI;

    public function __construct() {
        $this->CI = &get_instance();
    }

    public function json($data, $status, $message = '') {
        $responseData = [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];

        $this->CI->output->set_content_type('application/json');
        $this->CI->output->set_status_header($status);
        $this->CI->output->set_output(json_encode($responseData));
    }
}

