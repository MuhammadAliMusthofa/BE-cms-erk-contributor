<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faqs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Model_api');
        $this->load->library('response');
    }

    public function list() {
        $faqs = $this->Model_api->get_faqs();
        if ($faqs) {
            $formatted_faqs = array();
    
            foreach ($faqs as $record) {
                $formatted_record = array(
                    'id' => $record['id'],
                    'question' => $record['question'] ?? 'Data Not Available',
                    'answer' => $record['answer'] ?? 'Data Not Available'
                );
    
                $formatted_faqs[] = $formatted_record;
            }
    
            $this->response->json($formatted_faqs, 200); 
        } else {
            $this->response->json(['error' => 'No FAQs found'], 404); 
        }
    }    
}