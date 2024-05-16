<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// header("Access-Control-Allow-Methods: GET, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");

class Video_api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Model_api');
        $this->load->model('Chart_model');
        $this->load->library('response');
    }

    public function index() {
        $videos = $this->Model_api->get_videos();
        if ($videos) {
            $formatted_videos = array();
    
            foreach ($videos as $video) {
                $createdAtTimestamp = strtotime($video['createdAt']);
                $currentTimestamp = time();
                $durationInSeconds = $currentTimestamp - $createdAtTimestamp;
                $days = floor($durationInSeconds / (24 * 3600));
                $hours = floor(($durationInSeconds % (24 * 3600)) / 3600);
            
                $formatted_video = array(
                    'id' => $video['id'],
                    'title' => array(
                        'video' => isset($video['filename_id']) ? $video['filename_id'] : 'No video available',
                        'label' => isset($video['labels']) ? $video['labels'] : 'No label available',
                    ),
                    'video' => isset($video['filename_id']) ? $video['filename_id'] : 'No video available',
                    'visibilitas' => ($video['publish'] == 1) ? 'Publish' : 'Not Publish',
                    'pembatasan' => null,
                    'komentar' => ($video['publish'] == 1) ? 'Publish' : 'Not Publish',
                    'performa' => "$days days and $hours hours ago",
                    'tayangan' => isset($video['views']) ? $video['views'] : 'Belum Pernah Tayang',
                    'penayangan' => isset($video['views']) ? $video['views'] : 'Belum Pernah Ditayangkan',
                    'ratanonton' => isset($video['views']) ? $video['views'] : 'Belum Pernah Ditayangkan',
                    'durasi' => isset($video['views']) ? $video['views'] : 'Belum Pernah Di Play',
                    'persentase' => isset($video['views']) ? $video['views'] : 'Belum Pernah Di Play',
                    'suka' => isset($video['likes']) ? $video['likes'] : 'No one likes it',
                    'date' => $video['createdAt'],
                    'imgPath' => "https://erklika.id:9024/assets/upload_thumbnail/" . (isset($video['thumbnail_id']) ? $video['thumbnail_id'] : 'No Thumbnail available'),
                    'description' => isset($video['description_id']) ? $video['description_id'] : 'No description'
                );
                
            
                $formatted_videos[] = $formatted_video;
            }
            $this->response->json($formatted_videos, 200); // Send JSON response with HTTP status code 200 (OK)
        } else {
            $this->response->json(['error' => 'No videos found'], 404); // Send JSON response with HTTP status code 404 (Not Found)
        }
    }

    public function count_all_videos() {
        $totalVideosCount = $this->Chart_model->getTotalVideosCount();
        $data['totalVideosCount'] = $totalVideosCount;

        json_encode($totalVideosCount);

        $this->response->json([
            'countvideos' => $totalVideosCount
        ], 200);
    }

    public function count_all_coment() {
        $countcoment = $this->Chart_model->getcountcoment();
        $data['countcoment'] = $countcoment;

        json_encode($countcoment);

        $this->response->json([
            'countcoment' => $countcoment
        ], 200);
    }

    public function count_all_visitor() {
        $countvisitor = $this->Chart_model->getcountvisitor();
        $data['countvisitor'] = $countvisitor;

        json_encode($countvisitor);

        $this->response->json([
            'countvisitor' => $countvisitor
        ], 200);
    
    }
    public function count_all_subscribe() {
        $countsubscribe = $this->Chart_model->getcountsubscribe();
        $data['countsubscribe'] = $countsubscribe;

        json_encode($countsubscribe);

        $this->response->json([
            'countsubscribe' => $countsubscribe
        ], 200);
    }

    public function video_terbaru() {
        $videos = $this->Model_api->get_terbaru_videos();
        if ($videos) {
            $formatted_videos = array();
    
            foreach ($videos as $video) {
                $createdAtTimestamp = strtotime($video['createdAt']);
                $currentTimestamp = time();
                $durationInSeconds = $currentTimestamp - $createdAtTimestamp;
                $days = floor($durationInSeconds / (24 * 3600));
                $hours = floor(($durationInSeconds % (24 * 3600)) / 3600);
            
                $formatted_video = array(
                    'id' => $video['id'],
                    'performa' => "$days days and $hours hours ago",
                    'tayangan' => isset($video['views']) ? $video['views'] : 'Belum Pernah Tayang',
                    'penayangan' => isset($video['views']) ? $video['views'] : 'Belum Pernah Ditayangkan',
                    'ratanonton' => isset($video['views']) ? $video['views'] : 'Belum Pernah Ditayangkan',
                    'suka' => isset($video['likes']) ? $video['likes'] : 'No one likes it',
                    'imgPath' => "https://erklika.id:9024/assets/upload_thumbnail/" . (isset($video['thumbnail_id']) ? $video['thumbnail_id'] : 'No Thumbnail available')
                );
            
                $formatted_videos[] = $formatted_video;
            }
            $this->response->json($formatted_videos, 200); // Send JSON response with HTTP status code 200 (OK)
        } else {
            $this->response->json(['error' => 'No videos found'], 404); // Send JSON response with HTTP status code 404 (Not Found)
        }
    }

    public function list_coment() {
        $coments = $this->Model_api->get_list_coment();
        if ($coments) {
            $formatted_coments = array();
            foreach ($coments as $record) {
                $formatted_record = array(
                    'id' => $record['id'],
                    'name' => $record['full_name'] ?? 'Data Not Available',
                    'email' => $record['email'] ?? 'Data Not Available',
                    'age' => $record['age'] ?? 'Data Not Available',
                    'phone' => $record['phone'] ?? 'Data Not Available',
                    'address' => $record['address'] ?? 'Data Not Available',
                    'city' => $record['city'] ?? 'Data Not Available',
                    'zipCode' => $record['zip_code'] ?? 'Data Not Available',
                    'registrarId' => null,
                    'imgAvatar' => null,
                    'imgPath' => "https://erklika.id:9024/assets/upload_thumbnail/" . ($video['thumbnail_id'] ?? 'No Thumbnail available'),
                    'judul' => $record['name_id'] ?? 'Data Not Available'
                );
                
                $formatted_coments[] = $formatted_record;
            }
            $this->response->json($formatted_coments, 200); // Send JSON response with HTTP status code 200 (OK)
        } else {
            $this->response->json(['error' => 'No coments found'], 404); // Send JSON response with HTTP status code 404 (Not Found)
        }
    }

    public function faqs() {
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