<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Model_api');
        $this->load->library('response');
    }
    public function OKElist() {
        $coments = $this->Model_api->get_list_coment();
    
        if ($coments) {
            $formatted_coments = array();
    
            foreach ($coments as $record) {
                // Add stars based on the rating value
                $stars = '';
                $rating = $record['rating'];
                for ($i = 1; $i <= $rating; $i++) {
                    $stars .= '⭐'; // You can use any star icon or HTML entity here
                }
                $coment_id = $record['id'];
                // $answer = $this->db->query("SELECT vrh.id, vrh.vid, usr.full_name AS replay_name, vrh.description, vrh.createdAt
                // FROM sv_video_reviews_history vrh
                // INNER JOIN sv_users usr ON usr.id = vrh.uid
                // WHERE vrh.parent_id = '$coment_id'")->result();

                $answer = $this->db->query("SELECT vrh.id, vrh.vid, usr.full_name AS replay_name, vrh.description, vrh.createdAt, v.name_id AS judul
                    FROM sv_video_reviews_history vrh
                    INNER JOIN sv_users usr ON usr.id = vrh.uid
                    INNER JOIN sv_videos v ON v.id = vrh.vid
                    WHERE vrh.parent_id = '$coment_id'")->result();
    
                $formatted_record = array(
                    'id' => $record['id'],
                    'rate' => $stars,
                    'vid' => $record['vid'],
                    'name' => $record['full_name'] ?? 'Data Not Available',
                    'description' => $record['description'] ?? 'Data Not Available',
                    'email' => $record['email'] ?? 'Data Not Available',
                    'age' => $record['age'] ?? 'Data Not Available',
                    'phone' => $record['phone'] ?? 'Data Not Available',
                    'address' => $record['address'] ?? 'Data Not Available',
                    'city' => $record['city'] ?? 'Data Not Available',
                    'zipCode' => $record['zip_code'] ?? 'Data Not Available',
                    'judul' => $record['name_id'] ?? 'Data Not Available',
                    'answers' => $answer,
                    'registrarId' => null,
                    'imgAvatar' => null,
                    'imgPath' => "https://192.168.40.41/erklika-cms-2/assets/upload_thumbnail/" . ($record['thumbnail_id'] ?? 'No Thumbnail available'),
                );
                $formatted_coments[] = $formatted_record;
            }
    
            $this->response->json($formatted_coments, 200);
        } else {
            $this->response->json(['error' => 'No comments found'], 404);
        }
    }
    public function list() {
        $coments = $this->Model_api->get_list_coment();
    
        if ($coments) {
            $formatted_coments = array();
    
            foreach ($coments as $record) {
                // Check if the comment has a parent_id
                if (empty($record['parent_id'])) {
                    // Add stars based on the rating value
                    $stars = '';
                    $rating = $record['rating'];
                    for ($i = 1; $i <= $rating; $i++) {
                        $stars .= '⭐'; // You can use any star icon or HTML entity here
                    }
                    $coment_id = $record['id'];
    
                    $answer = $this->db->query("SELECT vrh.id, vrh.vid, vrh.parent_id AS replay_coment, usr.full_name AS replay_name, vrh.description, vrh.createdAt, v.name_id AS judul
                        FROM sv_video_reviews_history vrh
                        INNER JOIN sv_users usr ON usr.id = vrh.uid
                        INNER JOIN sv_videos v ON v.id = vrh.vid
                        WHERE vrh.parent_id = '$coment_id'
                        ORDER BY vrh.createdAt DESC
                        LIMIT 1")->result();
    
                    if (empty($answer)) {
                        // If $answer is empty, fill in appropriate values
                        $answer = array(
                            'replay_name' => 'No Replies Yet',
                        );
                    }
    
                    $formatted_record = array(
                        'id' => $record['id'],
                        'rate' => $stars,
                        'vid' => $record['vid'],
                        'videoBy' => $record['createdBy'],
                        'parent_id' => $record['parent_id'],
                        'name' => $record['full_name'] ?? 'Data Not Available',
                        'description' => $record['description'] ?? 'Data Not Available',
                        'email' => $record['email'] ?? 'Data Not Available',
                        'age' => $record['age'] ?? 'Data Not Available',
                        'phone' => $record['phone'] ?? 'Data Not Available',
                        'address' => $record['address'] ?? 'Data Not Available',
                        'city' => $record['city'] ?? 'Data Not Available',
                        'zipCode' => $record['zip_code'] ?? 'Data Not Available',
                        'judul' => $record['name_id'] ?? 'Data Not Available',
                        'answers' => $answer,
                        'registrarId' => null,
                        'imgAvatar' => null,
                        'imgPath' => "https://192.168.40.41/erklika-cms-2/assets/upload_thumbnail/" . ($record['thumbnail_id'] ?? 'No Thumbnail available'),
                    );
                    $formatted_coments[] = $formatted_record;
                }
            }
    
            $this->response->json($formatted_coments, 200);
        } else {
            $this->response->json(['error' => 'No comments found'], 404);
        }
    }
    public function listVideoBy($createdBy) {
        $coments = $this->Model_api->get_comments_by_videoBy($createdBy);
    
        if ($coments) {
            $formatted_coments = array();
    
            foreach ($coments as $record) {
                // Check if the current comment belongs to the specified videoBy
                if ($record['createdBy'] == $createdBy) {
                    // Add stars based on the rating value
                    $stars = '';
                    $rating = $record['rating'];
                    for ($i = 1; $i <= $rating; $i++) {
                        $stars .= '⭐'; // You can use any star icon or HTML entity here
                    }
                    $coment_id = $record['id'];
    
                    $answers_query = $this->db->query("SELECT vrh.id, vrh.vid, vrh.parent_id, vrh.createdAt, usr.full_name AS replay_name, vrh.description, vrh.createdAt, v.name_id AS judul
                        FROM sv_video_reviews_history vrh
                        INNER JOIN sv_users usr ON usr.id = vrh.uid
                        INNER JOIN sv_videos v ON v.id = vrh.vid
                        WHERE vrh.parent_id = '$coment_id'
                        ORDER BY vrh.createdAt DESC");
    
                    $answers = $answers_query->result();
    
                    // Group answers based on parent_id
                    $grouped_answers = array();
                    foreach ($answers as $answer) {
                        $parent_id = $answer->parent_id;
    
                        if (!isset($grouped_answers[$parent_id])) {
                            $grouped_answers[$parent_id] = array();
                        }
    
                        $grouped_answers[$parent_id][] = array(
                            'id' => $answer->id,
                            'vid' => $answer->vid,
                            'parent_id' => $answer->parent_id,
                            'replay_name' => $answer->replay_name,
                            'description' => $answer->description,
                            'createdAt' => $answer->createdAt,
                            'judul' => $answer->judul
                        );
                    }
    
                    // Now, assign the grouped answers to the main array
                    $formatted_record = array(
                        'id' => $record['id'],
                        'rate' => $stars,
                        'vid' => $record['vid'],
                        'videoBy' => $record['createdBy'],
                        'name' => $record['full_name'] ?? 'Data Not Available',
                        'description' => $record['description'] ?? 'Data Not Available',
                        // 'email' => $record['email'] ?? 'Data Not Available',
                        // 'age' => $record['age'] ?? 'Data Not Available',
                        // 'phone' => $record['phone'] ?? 'Data Not Available',
                        // 'address' => $record['address'] ?? 'Data Not Available',
                        // 'city' => $record['city'] ?? 'Data Not Available',
                        // 'zipCode' => $record['zip_code'] ?? 'Data Not Available',
                        'judul' => $record['name_id'] ?? 'Data Not Available',
                        'createdAt' => $record['createdAt'] ?? 'Data Not Available',
                        'registrarId' => null,
                        'imgAvatar' => null,
                        'imgPath' => "https://192.168.40.41/erklika-cms-2/assets/upload_thumbnail/" . ($record['thumbnail_id'] ?? 'No Thumbnail available'),
                    );
    
                    // Check if there are answers and add to the formatted record
                    if (!empty($grouped_answers)) {
                        $formatted_record['answers'] = $grouped_answers;
                    }
    
                    $formatted_coments[] = $formatted_record;
                }
            }
    
            $this->response->json($formatted_coments, 200);
        } else {
            $this->response->json(['error' => 'No comments found'], 404);
        }
    }
    public function detail($vid) {
        $coments = $this->Model_api->get_detail_coment($vid);
    
        if ($coments) {
            $formatted_coments = array();
    
            foreach ($coments as $record) {
                // Add stars based on the rating value
                $stars = '';
                $rating = $record['rating'];
                for ($i = 1; $i <= $rating; $i++) {
                    $stars .= '⭐'; // You can use any star icon or HTML entity here
                }
    
                $coment_id = $record['id'];
    
                // Check if it has a parent_id
                if (!empty($record['parent_id'])) {
                    // If it has a parent_id, fetch answers
                    // $answer = $this->db->query("SELECT vrh.id, vrh.vid, usr.full_name AS replay_name, vrh.description, vrh.createdAt
                    //     FROM sv_video_reviews_history vrh
                    //     INNER JOIN sv_users usr ON usr.id = vrh.uid
                    //     WHERE vrh.parent_id = '$coment_id'")->result();

                    $answer = $this->db->query("SELECT vrh.id, vrh.vid, usr.full_name AS replay_name, vrh.description, vrh.createdAt, v.name_id AS judul
                    FROM sv_video_reviews_history vrh
                    INNER JOIN sv_users usr ON usr.id = vrh.uid
                    INNER JOIN sv_videos v ON v.id = vrh.vid
                    WHERE vrh.parent_id = '$coment_id'")->result();

    
                    $formatted_record = array(
                        'id' => $record['id'],
                        'rate' => $stars,
                        'vid' => $record['vid'],
                        'name' => $record['full_name'] ?? 'Data Not Available',
                        'judul' => $record['name_id'] ?? 'Data Not Available',
                        'description' => $record['description'] ?? 'Data Not Available',
                        'email' => $record['email'] ?? 'Data Not Available',
                        'age' => $record['age'] ?? 'Data Not Available',
                        'phone' => $record['phone'] ?? 'Data Not Available',
                        'address' => $record['address'] ?? 'Data Not Available',
                        'city' => $record['city'] ?? 'Data Not Available',
                        'zipCode' => $record['zip_code'] ?? 'Data Not Available',
                        'title' => $record['name_id'] ?? 'Data Not Available',
                        'answers' => $answer,
                        'registrarId' => null,
                        'imgAvatar' => null,
                        'imgPath' => "https://192.168.40.41/erklika-cms-2/assets/upload_thumbnail/" . ($record['thumbnail_id'] ?? 'No Thumbnail available'),
                    );
                } else {
                    // If it doesn't have a parent_id, include the comment only
                    $formatted_record = array(
                        'id' => $record['id'],
                        'rate' => $stars,
                        'vid' => $record['vid'],
                        'name' => $record['full_name'] ?? 'Data Not Available',
                        'description' => $record['description'] ?? 'Data Not Available',
                        'email' => $record['email'] ?? 'Data Not Available',
                        'age' => $record['age'] ?? 'Data Not Available',
                        'phone' => $record['phone'] ?? 'Data Not Available',
                        'address' => $record['address'] ?? 'Data Not Available',
                        'city' => $record['city'] ?? 'Data Not Available',
                        'zipCode' => $record['zip_code'] ?? 'Data Not Available',
                        'title' => $record['name_id'] ?? 'Data Not Available',
                        'answers' => array(), // Empty answers for comments without parent_id
                        'registrarId' => null,
                        'imgAvatar' => null,
                        'imgPath' => "https://192.168.40.41/erklika-cms-2/assets/upload_thumbnail/" . ($record['thumbnail_id'] ?? 'No Thumbnail available'),
                    );
                }
    
                $formatted_coments[] = $formatted_record;
            }
    
            $this->response->json($formatted_coments, 200);
        } else {
            $this->response->json(['error' => 'No comments found for vid: ' . $vid], 404);
        }
    }
    public function count_coment() {
        $countcoment = $this->Model_api->getcountcoment();
        $data['countcoment'] = $countcoment;

        json_encode($countcoment);

        $this->response->json([
            'countcoment' => $countcoment
        ], 200);
    }
    public function replay() {
        $comment_data = array(
            'uid' => $this->input->post('uid'),
            'vid' => $this->input->post('vid'),
            'description' => $this->input->post('description'),
            'parent_id' => $this->input->post('parent_id'),
        );
    
        $new_comment = $this->Model_api->post_comment($comment_data);
    
        if ($new_comment) {
            $this->response->json($new_comment, 201);
        } else {
            $this->response->json(['error' => 'Failed to post the comment'], 500);
        }
    }
    
}