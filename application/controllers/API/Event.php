<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Model_api');
        $this->load->library('response');
        $this->load->library('form_validation');
    }

    public function all() {
        $event = $this->Model_api->get_event();
        if ($event) {
            $formatted_event = array();
    
            foreach ($event as $record) {
                $formatted_record = array(
                    'id' => $record['id'],
                    'vid' => $record['vid'],
                    'event_name' => $record['event_name'] ?? 'Data Not Available',
                    'startdate' => $record['startdate'] ?? 'Data Not Available',
                    'enddate' => $record['enddate'] ?? 'Data Not Available',
                    'createdBy' => $record['createdBy'] ?? 'Data Not Available'
                );
    
                $formatted_event[] = $formatted_record;
            }
    
            $this->response->json($formatted_event, 200); 
        } else {
            $this->response->json(['error' => 'No event found'], 404); 
        }
    }
    public function playlist($createdBy) {
        $event = $this->Model_api->getplaylist($createdBy);
    
        if ($event) {
            $formatted_event = array();
    
            foreach ($event as $record) {
                $formatted_record = array(
                    'id' => $record['id'],
                    'vid' => $record['vid'],
                    'event_name' => $record['event_name'] ?? 'Data Not Available',
                    'name_id' => $record['name_id'] ?? 'Data Not Available',
                    'startdate' => $record['startdate'] ?? 'Data Not Available',
                    'enddate' => $record['enddate'] ?? 'Data Not Available',
                    'createdBy' => $record['createdBy'] ?? 'Data Not Available',
                    'thumbnail_id' => "http://localhost/erklika-cms-2/assets/upload_thumbnail/" . (isset($record['thumbnail_id']) ? $record['thumbnail_id'] : 'No Thumbnail available'),
                    'filename_id' => isset($record['filename_id']) ? $record['filename_id'] : 'No filename_id available',
                    'views' => isset($record['views']) ? $record['views'] : 'Belum Pernah Tayang',
                );
    
                $formatted_event[] = $formatted_record;
            }
    
            $this->response->json($formatted_event, 200);
        } else {
            $this->response->json(['error' => 'No event found'], 404);
        }
    }
    public function playlistevent($createdBy) {
        $event = $this->Model_api->getplaylist($createdBy);
        
        if ($event) {
            $formatted_event = array();
            
            $grouped_events = array();
            foreach ($event as $record) {
                $event_name = $record['event_name'] ?? 'Data Not Available';
                if (!isset($grouped_events[$event_name])) {
                    $grouped_events[$event_name] = array();
                }
                $grouped_events[$event_name][] = $record;
            }
    
            foreach ($grouped_events as $event_name => $events) {
                $formatted_event[$event_name] = array();
                foreach ($events as $record) {
                    $formatted_record = array(
                        'id' => $record['id'],
                        'vid' => $record['vid'],
                        'event_name' => $record['event_name'] ?? 'Data Not Available',
                        'name_id' => $record['name_id'] ?? 'Data Not Available',
                        'startdate' => $record['startdate'] ?? 'Data Not Available',
                        'enddate' => $record['enddate'] ?? 'Data Not Available',
                        'createdBy' => $record['createdBy'] ?? 'Data Not Available',
                        'thumbnail_id' => "https://10.1.4.41/erklika-cms-2/assets/upload_thumbnail/" . (isset($record['thumbnail_id']) ? $record['thumbnail_id'] : 'No Thumbnail available'),
                    );
                    $formatted_event[$event_name][] = $formatted_record;
                }
            }
    
            $this->response->json($formatted_event, 200);
        } else {
            $this->response->json(['error' => 'No event found'], 404);
        }
    }
    public function createby($id) {
        $user_data = $this->Model_api->getVideoBy($id);
    
        if ($user_data) {
            $event_name = $this->input->post('event_name');
            $startdate = $this->input->post('startdate');
            $enddate = $this->input->post('enddate');
            $createdBy = $this->input->post('createdBy');
            $vid = $this->input->post('vid') ?? [];
    
            if (empty($event_name) || empty($startdate) || empty($enddate)) {
                $response = array('status' => 'error', 'message' => 'Semua kolom harus diisi');
            } else {
                $insert_result = $this->Model_api->insert_event($vid, $event_name, $startdate, $enddate, $createdBy);
    
                if ($insert_result['status'] === 'success') {
                    $response = array('status' => 'success', 'message' => $insert_result['message']);
                } else {
                    $response = array('status' => 'error', 'message' => $insert_result['message']);
                }
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Pengguna tidak ditemukan');
        }
    
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function getVideoByCreatedBy($createdBy)
    {
        if (is_array($createdBy)) {
            $videos = $this->Model_api->getVideoByCreatedBy($createdBy);
        } else {
            $videos = $this->Model_api->getVideoByCreatedBy($createdBy);
        }

        if ($videos !== false) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'success', 'data' => $videos]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'No videos found.']));
        }
    }

    public function videomultiple($createdBy) {
        $videos = $this->Model_api->getVideoByCreatedBy($createdBy);
        if ($videos) {
            $formatted_videos = array();
    
            foreach ($videos as $video) {$formatted_video = array(
                    'id' => $video['id'],
                    'name_id' => isset($video['name_id']) ? $video['name_id'] : 'No video available',
                );
                
            
                $formatted_videos[] = $formatted_video;
            }
            $this->response->json($formatted_videos, 200);
        } else {
            $this->response->json(['error' => 'No videos found'], 404);
        }
    }
    public function create() {
        $json_data = file_get_contents('php://input');
    
        $data = json_decode($json_data, true);
    
        if (empty($data['event_name']) || empty($data['startdate']) || empty($data['enddate'])) {
            $response = array('status' => 'error', 'message' => 'All fields must be filled');
        } else {
            $event_name = $data['event_name'];
            $startdate = $data['startdate'];
            $enddate = $data['enddate'];
    
            $insert_result = $this->Model_api->insert_event($event_name, $startdate, $enddate);
    
            if ($insert_result['status'] === 'success') {
                $response = array('status' => 'success', 'message' => $insert_result['message']);
            } else {
                $response = array('status' => 'error', 'message' => $insert_result['message']);
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
}