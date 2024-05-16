<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Model_api');
        $this->load->library('response');
        // $this->load->library('output');
    }
    public function list() {
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
                        'thumbnail_id' => "http://localhost/erklika-cms-2/assets/upload_thumbnail/" . (isset($video['thumbnail_id']) ? $video['thumbnail_id'] : 'No Thumbnail available'),
                       'name_id' => isset($video['name_id']) ? $video['name_id'] : 'No label available',
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
                    'description' => isset($video['description_id']) ? $video['description_id'] : 'No description',
                    'views' => isset($video['views']) ? $video['views'] : 'No one views it'
                );
                
            
                $formatted_videos[] = $formatted_video;
            }
            $this->response->json($formatted_videos, 200); 
        } else {
            $this->response->json(['error' => 'No videos found'], 404); 
        }
    }
    public function count_videos() {
        $totalVideosCount = $this->Model_api->getTotalVideosCount();
        $data['totalVideosCount'] = $totalVideosCount;

        json_encode($totalVideosCount);

        $this->response->json([
            'countvideos' => $totalVideosCount
        ], 200);
    }
    public function count_visitor() {
        $countvisitor = $this->Model_api->getcountvisitor();
        $data['countvisitor'] = $countvisitor;

        json_encode($countvisitor);

        $this->response->json([
            'countvisitor' => $countvisitor
        ], 200);
    }
    public function getAllPenayangan() {
        $top_videos = $this->Model_api->getPenayananAny();
        
        if ($top_videos) {
            $this->output->set_content_type('application/json')->set_output(json_encode($top_videos));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'No videos found']));
        }
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
                    'name_id' => isset($video['name_id']) ? $video['name_id'] : 'Belum Pernah Tayang',
                    'performa' => "$days days and $hours hours ago",
                    'tayangan' => isset($video['views']) ? $video['views'] : 'Belum Pernah Tayang',
                    'penayangan' => isset($video['views']) ? $video['views'] : 'Belum Pernah Ditayangkan',
                    'ratanonton' => isset($video['views']) ? $video['views'] : 'Belum Pernah Ditayangkan',
                    'suka' => isset($video['likes']) ? $video['likes'] : 'No one likes it',
                    'thumbnail_id' => "http://localhost/erklika-cms-2/assets/upload_thumbnail/" . (isset($video['thumbnail_id']) ? $video['thumbnail_id'] : 'No Thumbnail available')
                );
            
                $formatted_videos[] = $formatted_video;
            }
            $this->response->json($formatted_videos, 200); 
        } else {
            $this->response->json(['error' => 'No videos found'], 404); 
        }
    }
    public function viewbycity() {
        $usersByCity = $this->Model_api->get_user_count_by_city();
    
        if ($usersByCity) {
    
            foreach ($usersByCity as $record) {
                $formattedRecord = array(
                    'kota' => $record['city_name'] ?? 'Data Not Available',
                    'pria' => rand(20, 30),
                    'wanita' => rand(25, 35), 
                );
    
                $formattedData[] = $formattedRecord;
            }
    
            $this->response->json($formattedData, 200); 
        } else {
            $this->response->json(['error' => 'No data found'], 404); 
        }
    }
    public function viewbyage() {
        $usersByage = $this->Model_api->get_viewbyage();
    
        if ($usersByage) {
            $formattedData = array();
    
            foreach ($usersByage as $record) {
                $formattedRecord = array(
                    // 'id' => $record['user_id'],
                    'age' => $record['age'] ?? 'Data Not Available',
                    'pria' => rand(20, 30),
                    'wanita' => rand(25, 35), 
                );
    
                $formattedData[] = $formattedRecord;
            }
    
            $this->response->json($formattedData, 200); 
        } else {
            $this->response->json(['error' => 'No data found'], 404);
        }
    }
    public function viewbymedia() {
        $usersByMedia = $this->Model_api->get_user_count_by_media();
    
        if ($usersByMedia) {
            $formattedData = array();
    
            foreach ($usersByMedia as $record) {
                $formattedRecord = array(
                    'media' => $record['media'] ?? 'Data Not Available',
                    'pria' => rand(20, 30),
                    'wanita' => rand(25, 35), 
                );
    
                $formattedData[] = $formattedRecord;
            }
    
            $this->response->json($formattedData, 200);
        } else {
            $this->response->json(['error' => 'No data found'], 404);
        }
    }
    public function periodvideopop() {
        $populer = $this->Model_api->get_populer();
        if ($populer) {
            $formatted_populer = array();
    
            foreach ($populer as $video) {
                $createdAtTimestamp = strtotime($video['createdAt']);
                $currentTimestamp = time();
                $durationInSeconds = $currentTimestamp - $createdAtTimestamp;
                $days = floor($durationInSeconds / (24 * 3600));
                $hours = floor(($durationInSeconds % (24 * 3600)) / 3600);
            
                $formatted_video = array(
                    'id' => $video['id'],
                    'name_id' => isset($video['name_id']) ? $video['name_id'] : 'No Name',
                    'thumbnail_id' => "http://localhost/erklika-cms-2/assets/upload_thumbnail/" . (isset($video['thumbnail_id']) ? $video['thumbnail_id'] : 'No Thumbnail available'),
                    'performa' => "$days days and $hours hours ago",
                    'tayangan' => isset($video['views']) ? $video['views'] : 'Belum Pernah Tayang',
                    'penayangan' => isset($video['views']) ? $video['views'] : 'Belum Pernah Ditayangkan',
                    'ratanonton' => isset($video['views']) ? $video['views'] : 'Belum Pernah Ditayangkan',
                    'waktutonton' => isset($video['views']) ? $video['views'] : 'Belum Pernah Di Play',
                    'date' => $video['createdAt'],
                    'description' => isset($video['description_id']) ? $video['description_id'] : 'No description'
                );
                
            
                $formatted_populer[] = $formatted_video;
            }
            $this->response->json($formatted_populer, 200); 
        } else {
            $this->response->json(['error' => 'No videos found'], 404); 
        }
    }
    public function detailvideo($id)
    {
        $detail = $this->Model_api->get_detail_video_by_id($id);
        
        if ($detail) {
            $formatted_detail = array();
            $formatted_video = array(
                'id' => $detail['id'],
                'video_id' => isset($detail['video_id']) ? $detail['video_id'] : 'No video_id available',
                'video_en' => isset($detail['video_en']) ? $detail['video_en'] : 'No video_id available',
                'name_id' => isset($detail['name_id']) ? $detail['name_id'] : 'No name_id available',
                'name_en' => isset($detail['name_en']) ? $detail['name_en'] : 'No name_en available',
                'description_id' => isset($detail['description_id']) ? $detail['description_id'] : 'No description_id available',
                'description_en' => isset($detail['description_en']) ? $detail['description_en'] : 'No description_en available',
                'caption_id' => isset($detail['caption_id']) ? $detail['caption_id'] : 'No caption_id available',
                'caption_en' => isset($detail['caption_en']) ? $detail['caption_en'] : 'No caption_en available',
                'label' => isset($detail['labels']) ? $detail['labels'] : 'No label available',
                'tag' => isset($detail['tags']) ? $detail['tags'] : 'No label available',
                'filename_id' => isset($detail['filename_id']) ? $detail['filename_id'] : 'No filename_id available',
                'filename_en' => isset($detail['filename_en']) ? $detail['filename_en'] : 'No filename_en available',
                'master_url' => isset($detail['master_url']) ? $detail['master_url'] : 'No master_url available',
                'callback_url' => isset($detail['callback_url']) ? $detail['callback_url'] : 'No callback_url available',
                'thumbnail_id' => isset($detail['thumbnail_id']) ? $detail['thumbnail_id'] : 'No thumbnail_id available',
                'thumbnail_id' => isset($detail['thumbnail_id']) ? $detail['thumbnail_id'] : 'No thumbnail_id available',
                'poster_id' => isset($detail['poster_id']) ? $detail['poster_id'] : 'No poster_id available',
                'poster_en' => isset($detail['poster_en']) ? $detail['poster_en'] : 'No poster_en available',
                'ingest_status_id' => isset($detail['ingest_status_id']) ? $detail['ingest_status_id'] : 'No ingest_status_id available',
                'ingest_status_en' => isset($detail['ingest_status_en']) ? $detail['ingest_status_en'] : 'No ingest_status_en available',
                'file_worksheet' => isset($detail['file_worksheet']) ? $detail['file_worksheet'] : 'No file_worksheet available',
                'state' => isset($detail['state']) ? $detail['state'] : 'No state available',
                'recommended' => isset($detail['recommended']) ? $detail['recommended'] : 'No recommended available',
                'free' => isset($detail['free']) ? $detail['free'] : 'No free available',
                'views' => isset($detail['views']) ? $detail['views'] : 'No views available',
                'likes' => isset($detail['likes']) ? $detail['likes'] : 'No likes available',
                'show_homepage' => isset($detail['show_homepage']) ? $detail['show_homepage'] : 'No show_homepage available',
                'publish' => isset($detail['publish']) ? $detail['publish'] : 'No publish available',
                'createdAt' => isset($detail['createdAt']) ? $detail['createdAt'] : 'No createdAt available',
                'createdBy' => isset($detail['createdBy']) ? $detail['createdBy'] : 'No createdBy available',
                'updatedAt' => isset($detail['updatedAt']) ? $detail['updatedAt'] : 'No updatedAt available',
                'updatedBy' => isset($detail['updatedBy']) ? $detail['updatedBy'] : 'No updatedBy available',
                'deletedat' => isset($detail['deletedat']) ? $detail['deletedat'] : 'No deletedat available',
                'thumbnail_id' => "http://localhost/erklika-cms-2/assets/upload_thumbnail/" . (isset($detail['thumbnail_id']) ? $detail['thumbnail_id'] : 'No Thumbnail available')
            );

            $formatted_detail[] = $formatted_video;
            
            $this->response->json($formatted_detail, 200); // Send JSON response with HTTP status code 200 (OK)
        } else {
            $this->response->json(['error' => 'No videos found'], 404); // Send JSON response with HTTP status code 404 (Not Found)
        }
    }
    public function video_ar($video_id)
    {
        $video_info = $this->Model_api->get_video_ar($video_id);

        if ($video_info) {
            $data = array(
                'repository' => isset($video_info['repository']) ? $video_info['repository'] : 'No Repository available',
                'project' => isset($video_info['project']) ? $video_info['project'] : 'No Project available'
            );

            $this->response->json($data, 200);
        } else {
            $this->response->json(['error' => 'No videos found'], 404);
        }
    }
    public function add() {
        $data = $this->input->post();
    
        error_log("Received POST data: " . print_r($data, true));
    
        $createdBy = $this->input->post('createdBy');
    
        $filename_id = $this->uploadFile('filename_id', './assets/upload_video/', 'mp4');
    
        error_log("filename_id: " . $filename_id);
    
        $insert_result = $this->Model_api->insert_video($filename_id, $createdBy);
    
        if ($insert_result['status'] === 'success') {
            $inserted_data = array(
                'filename_id' => $filename_id,
                'createdBy' => $createdBy,
            );
    
            $insert_id = $this->db->insert_id();
    
            $response = array('status' => 'success', 'message' => $insert_result['message'], 'id' => $insert_id, 'data' => $inserted_data);
        } else {
            $response = array('status' => 'error', 'message' => $insert_result['message']);
        }
    
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    private function uploadFile($fileField, $uploadPath, $allowedTypes)
    {
        if (!empty($_FILES[$fileField]['name'])) {
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = $allowedTypes;
            $config['file_name'] = date("mdYiHs");
    
            $this->load->library('upload', $config);
    
            if (!$this->upload->do_upload($fileField)) {
                // Log pesan kesalahan
                $error_message = 'File Upload Error: ' . $this->upload->display_errors();
                error_log($error_message);
    
                // File upload gagal, berikan respons JSON dengan pesan error
                $response = array('status' => 'error', 'message' => $error_message);
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
                exit(); // Keluar untuk mencegah eksekusi lebih lanjut
            } else {
                // File upload berhasil, lanjutkan dengan logika database
                $file_info = $this->upload->data();
                return $file_info['file_name'];
            }
        }
        return null;
    }
    public function update_c($id)
    {
        $videoDetails = $this->Model_api->ali($id);

        if (!$videoDetails) {
            $this->output->set_status_header(404);
            $response = [
                'status' => 404,
                'message' => 'Video not found',
                'data' => null,
            ];
        } else {
            $input = json_decode(file_get_contents('php://input'), true);

            $name_id = $input['name_id'];
            $description_id = $input['description_id'];
            $publish = $input['publish'];
            $thumbnail_id = $input['thumbnail_id'];

            // Update the video details
            $array = [
                'name_id' => $name_id,
                'description_id' => $description_id,
                'publish' => $publish,
                'thumbnail_id' => $thumbnail_id,
                'updatedAt' => date("Y-m-d H:i:s"),
            ];
            
            $updated = $this->Model_api->update_data($id, $name_id, $description_id, $publish, $thumbnail_id);

            if ($updated) {
                $response = [
                    'status' => 200,
                    'message' => 'Video updated successfully',
                    'data' => [
                        'name_id' => $name_id,
                        'description_id' => $description_id,
                        'publish' => $publish,
                        'thumbnail_id' => $thumbnail_id,
                    ],
                ];
            } else {
                $this->output->set_status_header(500);
                $response = [
                    'status' => 500,
                    'message' => 'Failed to update video',
                    'data' => null,
                ];
            }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    // pengisian detail video 
    public function aam_lab($id) {
        // Retrieve regular form data from $_POST
        $name_id = $this->input->post('name_id');
        $description_id = $this->input->post('description_id');
        $publish = $this->input->post('publish');
        $updatedBy = $this->input->post('updatedBy');

        // Fetch video_id from the database based on $id
        $video_details = $this->Model_api->aam_id($id);
        
        if (!$video_details) {
            $this->response->json(['error' => 'Video not found'], 404);
            return;
        }

        $video_id = $video_details['video_id'];
        $vid = $video_details['id'];

        // Fetch video labels and tags
        $video_labels = $this->Model_api->aam_labels($id);
        $video_tags = $this->Model_api->aam_tags($id);

        // Handle cases where label or tag queries fail
        $label_id = $video_labels ? $video_labels['id'] : null;
        $tag_id = $video_tags ? $video_tags['id'] : null;

        // Upload the file
        $thumbnail_id = $this->uploadFilePut('thumbnail_id', $video_id);

        // Call the update_data function in the model
        $updated = $this->Model_api->aam_update($id, $name_id, $description_id, $thumbnail_id, $publish, $updatedBy);

        // Save video labels and tags
        $label_id_input = $this->input->post('label_id');
        if ($label_id_input !== null) {
            $this->Model_api->save_video_labels($vid, $label_id_input);
        }
    

        $tag_id_input = $this->input->post('tag_id');
        if ($tag_id_input !== null) {
            $this->Model_api->save_video_tags($vid, $tag_id_input);
        }

        // Respond based on the update result
        if ($updated) {
            $this->response->json(['message' => 'Video updated successfully'], 200);
        } else {
            $this->response->json(['error' => 'Failed to update video'], 500);
        }
    }
    private function uploadFilePut($field_name, $video_id) {
        $config['upload_path'] = './assets/upload_thumbnail/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name'] = $video_id;  // Use $video_id directly as the file name

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($field_name)) {
            // Handle upload failure
            $error = $this->upload->display_errors();
            $this->response->json(['error' => $error], 400); // Adjust status code and response as needed
        } else {
            // Upload success
            $upload_data = $this->upload->data();
            return $upload_data['file_name'];
        }
    }
    public function labels() {
        $videos = $this->Model_api->get_labels();
        if ($videos) {
            $formatted_videos = array();
    
            foreach ($videos as $video) {$formatted_video = array(
                    'id' => $video['id'],
                    'label' => isset($video['label']) ? $video['label'] : 'No video available',
                );
                
            
                $formatted_videos[] = $formatted_video;
            }
            $this->response->json($formatted_videos, 200); // Send JSON response with HTTP status code 200 (OK)
        } else {
            $this->response->json(['error' => 'No videos found'], 404); // Send JSON response with HTTP status code 404 (Not Found)
        }
    }
    public function tags() {
        $videos = $this->Model_api->get_tags();
        if ($videos) {
            $formatted_videos = array();
    
            foreach ($videos as $video) {$formatted_video = array(
                    'id' => $video['id'],
                    'tags' => isset($video['tags']) ? $video['tags'] : 'No video available',
                );
                
            
                $formatted_videos[] = $formatted_video;
            }
            $this->response->json($formatted_videos, 200); // Send JSON response with HTTP status code 200 (OK)
        } else {
            $this->response->json(['error' => 'No videos found'], 404); // Send JSON response with HTTP status code 404 (Not Found)
        }
    }
    public function watch_last_30_days($createdBy) {
        $result = $this->Model_api->count_watch_history_last_30_days($createdBy);
        
        if ($result) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => true, 'data' => $result]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Failed to fetch data']));
        }
    }
    public function count_all_watch($createdBy) {
        $result = $this->Model_api->count_all_watch($createdBy);
        
        if ($result) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => true, 'data' => $result]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Failed to fetch data']));
        }
    }
    public function calculate_average_watch_count($createdBy) {
        $average_watch_count = $this->Model_api->calculate_average_watch_count($createdBy);

        if ($average_watch_count !== false) {
            $response = array(
                'success' => true,
                'average_watch_count' => $average_watch_count
            );
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Failed to calculate average watch count']));
        }
    }


}