<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_api extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_videos() 
    {
        $this->db->select('id, filename_id, name_id, publish, views, thumbnail_id, description_id, createdAt, updatedAt');
        $this->db->order_by('views', 'desc');
        $query = $this->db->get('sv_videos');
    
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function get_terbaru_videos() 
    {
        $this->db->select('id, filename_id, name_id, publish, views, thumbnail_id, description_id, createdAt, updatedAt');
        $this->db->order_by('createdAt', 'desc');
        $this->db->limit(3);
    
        $query = $this->db->get('sv_videos');
    
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    
    }  
    public function get_list_coment() 
    {
        $this->db->select('vrh.*, vrh.id, vrh.parent_id, vrh.uid, vrh.vid, v.createdBy, v.name_id, u.full_name, u.email, u.birthdate, u.phone, u.address, c.city_name, u.zip_code');
        $this->db->from('sv_video_reviews_history vrh');
        $this->db->join('sv_users u', 'u.id = vrh.uid', 'left');
        $this->db->join('sv_videos v', 'v.id = vrh.vid', 'left');
        $this->db->join('sv_cities c', 'c.id = u.id', 'left');

        $this->db->select("YEAR(CURDATE()) - YEAR(u.birthdate) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(u.birthdate, '%m%d')) AS age", false);
        $this->db->order_by('vrh.createdAt', 'DESC');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    
    }
    public function get_comments_by_videoBy($createdBy) 
    {
        $this->db->select('vrh.*, vrh.id, vrh.parent_id, vrh.uid, vrh.vid, v.createdBy, v.thumbnail_id, v.name_id, u.full_name, u.email, u.birthdate, u.phone, u.address, c.city_name, u.zip_code');
        $this->db->from('sv_video_reviews_history vrh');
        $this->db->join('sv_users u', 'u.id = vrh.uid', 'left');
        $this->db->join('sv_videos v', 'v.id = vrh.vid', 'left');
        $this->db->join('sv_cities c', 'c.id = u.id', 'left');
        $this->db->select("YEAR(CURDATE()) - YEAR(u.birthdate) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(u.birthdate, '%m%d')) AS age", false);
        $this->db->where('u.id', $createdBy);
        $this->db->order_by('vrh.createdAt', 'DESC');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    public function get_detail_coment($vid) 
    {
        $this->db->select('vrh.*, vrh.id, vrh.parent_id, vrh.uid, vrh.vid, v.name_id, u.full_name, u.email, u.birthdate, u.phone, u.address, c.city_name, u.zip_code');
        $this->db->from('sv_video_reviews_history vrh');
        $this->db->join('sv_users u', 'u.id = vrh.uid', 'left');
        $this->db->join('sv_videos v', 'v.id = vrh.vid', 'left');
        $this->db->join('sv_cities c', 'c.id = u.id', 'left');
    
        $this->db->where('vrh.vid', $vid);
    
        $this->db->select("YEAR(CURDATE()) - YEAR(u.birthdate) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(u.birthdate, '%m%d')) AS age", false);
        $this->db->order_by('vrh.createdAt', 'DESC');
    
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    public function post_comment($data)
    {
        $this->db->insert('sv_video_reviews_history', $data);
    
        $comment_id = $this->db->insert_id();
    
        $this->db->select('vrh.*, vrh.id, vrh.parent_id, vrh.uid, v.name_id, u.full_name, u.email, u.birthdate, u.phone, u.address, c.city_name, u.zip_code');
        $this->db->from('sv_video_reviews_history vrh');
        $this->db->join('sv_users u', 'u.id = vrh.uid', 'left');
        $this->db->join('sv_videos v', 'v.id = vrh.vid', 'left');
        $this->db->join('sv_cities c', 'c.id = u.id', 'left');
        $this->db->where('vrh.id', $comment_id);
    
        $this->db->select("YEAR(CURDATE()) - YEAR(u.birthdate) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(u.birthdate, '%m%d')) AS age", false);
    
        $query = $this->db->get();
    
        return ($query->num_rows() > 0) ? $query->row_array() : null;
    }
    public function get_viewbyage()
    {
        $this->db->select("DISTINCT YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(birthdate, '%m%d')) AS age", false);
        $this->db->from('sv_users');
        $this->db->where('birthdate IS NOT NULL'); 
        $this->db->group_by('age'); 
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    public function get_watch_history() 
    {
        $this->db->select('wh.*');
        $this->db->from('sv_watch_history as wh');
        $this->db->join('sv_users u', 'wh.uid = u.uid');
        $this->db->join('sv_videos v', 'wh.vid = v.vid');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    public function get_faqs()
    {
        $this->db->select('id, question, answer, kategori');
        $query = $this->db->get('sv_faqs');
    
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function get_user_count_by_city() 
    {
        $this->db->select('u.id as user_id, c.city_name, COUNT(u.city) as user_count');
        $this->db->from('sv_users u');
        $this->db->join('sv_cities c', 'c.id = u.city');
        $this->db->group_by('u.city');
    
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    public function get_user_count_by_media() 
    {
        $this->db->select('CASE 
                              WHEN d.device_type = "Android" THEN "Android"
                              WHEN d.device_type IN ("iPhone", "iOS") THEN "iOS"
                              ELSE "Web"
                          END AS media,
                          COUNT(u.id) as user_count');
        $this->db->from('sv_user_devices d');
        $this->db->join('sv_users u', 'd.uid = u.id');
        $this->db->group_by('media');
    
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    public function get_populer() 
    {
        $this->db->select('id, filename_id, name_id, publish, views, thumbnail_id, description_id, createdAt, updatedAt');
        $this->db->order_by('views', 'DESC');
        $this->db->limit(3);
        $query = $this->db->get('sv_videos');
    
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function get_penayangan() 
    {
        $this->db->select('id');
        $query = $this->db->get('sv_videos');
        $this->db->order_by('views', 'DESC');
    
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function get_detail_video() 
    {
        $this->db->select('v.*, adm.username');
        $this->db->from('sv_videos v');
        $this->db->join('sv_admin adm', 'v.createdBy = adm.id', 'left');
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function get_detail_video_by_id($id)
    {
        $this->db->select('v.*, adm.username, GROUP_CONCAT(DISTINCT l.label) as labels, GROUP_CONCAT(DISTINCT l.id) as id_labels, GROUP_CONCAT(DISTINCT t.tags) as tags,  GROUP_CONCAT(DISTINCT t.id) as id_tags' );
        $this->db->from('sv_videos v');
        $this->db->join('sv_admin adm', 'v.createdBy = adm.id', 'left');
        $this->db->join('sv_video_labels vl', 'v.id = vl.vid', 'left');
        $this->db->join('sv_labels l', 'vl.label_id = l.id', 'left');
        $this->db->join('sv_video_tags vt', 'v.id = vt.vid', 'left'); // Fix the join here
        $this->db->join('sv_tags t', 'vt.tag_id = t.id', 'left'); // Fix the join here
        $this->db->where('v.id', $id);
        $this->db->group_by('v.id'); // Menambahkan group by agar hasil sesuai dengan video yang dicari
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function get_list_users()
    {
        $this->db->select('u.*, c.city_name');
        $this->db->from('sv_users u');
        $this->db->join('sv_cities c', 'c.id = u.city');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function getPenayananAny() 
    {
        $query = $this->db->query('SELECT * FROM sv_videos ORDER BY views DESC LIMIT 3');
        return $query->result();
    }
    public function getTotalVideosCount() 
    {
        $query = $this->db->query('SELECT * FROM sv_videos');
        return $query->num_rows();
    }
    public function getcountvisitor() 
    {
        $query = $this->db->query('SELECT * FROM sv_user_history');
        return $query->num_rows();
    }
    public function getcountcoment() 
    {
        $query = $this->db->query('SELECT * FROM sv_video_reviews_history');
        return $query->num_rows();
    }
    public function getcountusers() 
    {
        $query = $this->db->query('SELECT * FROM sv_users');
        return $query->num_rows();
    }
    public function get_event() 
    {
        $this->db->select('id, event_name, startdate, enddate');
        $query = $this->db->get('sv_events');
    
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function getplaylist($createdBy)
    {
        $this->db->select('ev.id, ev.vid, ev.event_name, ev.startdate, ev.enddate, ev.createdBy, v.thumbnail_id, v.name_id, v.filename_id, v.views');
    
        $this->db->from('sv_events AS ev');
        $this->db->join('sv_videos AS v', 'ev.vid = v.id');
    
        $this->db->where('ev.createdBy', $createdBy);
    
        $this->db->order_by('ev.createdAt', 'desc');
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function insert_event($vid, $event_name, $startdate, $enddate, $createdBy) 
    {
        if (!empty($vid)) {
            $vidArray = json_decode($vid, true);
    
            foreach ($vidArray as $singleVid) {
                $data = array(
                    'vid' => $singleVid,
                    'event_name' => $event_name,
                    'startdate' => $startdate,
                    'enddate' => $enddate,
                    'createdBy' => $createdBy,
                    'createdAt' => date('Y-m-d H:i:s')
                );
    
                $insert_result = $this->db->insert('sv_events', $data);
                echo $this->db->last_query();
    
                if (!$insert_result) {
                    return ['status' => 'error', 'message' => $this->db->error()];
                }
            }
    
            return ['status' => 'success', 'message' => 'Events created successfully'];
        }
    
        return ['status' => 'error', 'message' => 'Empty vid array'];
    }
    public function get_video_ar($video_id)
    {
        $this->db->select('v.repository, v.project');
        $this->db->from('sv_videos v');
        $this->db->where('v.video_id', $video_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function get_comments_by_video_id($video_id)
    {
        $this->db->select('c.*, u.username');
        $this->db->from('sv_video_reviews_history c');
        $this->db->join('sv_users u', 'c.user_id = u.id', 'left');
        $this->db->where('c.video_id', $video_id);
        $this->db->order_by('c.id', 'ASC');
        return $this->db->get()->result_array();
    }
    public function insert_video($filename_id, $createdBy)
    {
        $data = array(
            'video_id' => date("mdYiHs"),
            'video_en' => date("mdYiHs"),
            'filename_id' => 'http://localhost/erklika-cms-2/assets/upload_video/'.$filename_id,
            'createdBy' => $createdBy,
            'createdAt' => date('Y-m-d H:i:s')
        );

        $insert_result = $this->db->insert('sv_videos', $data);

        if ($insert_result) {
            return ['status' => 'success', 'message' => 'Video information saved successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Failed to save video information'];
        }
    }
    public function update_detail_video_by_id($id, $data, $updateBy)
    {
        $name_id = isset($data['name_id']) ? $data['name_id'] : null;
        $description_id = isset($data['description_id']) ? $data['description_id'] : null;
        $thumbnail_id = isset($data['thumbnail_id']) ? $data['thumbnail_id'] : null;
        $updateBy = isset($data['updateBy']) ? $data['updateBy'] : null;
    
        $data['name_en'] = $name_id;
        $data['description_en'] = $description_id;
        $data['thumbnail_id'] = $thumbnail_id;
        $data['updateBy'] = $updateBy;
    
        $data['updatedAt'] = date('Y-m-d H:i:s');
    
        $this->db->where('id', $id);
        $this->db->update('sv_videos', $data);
        echo $this->db->last_query();
    
        return $this->db->affected_rows() > 0;
    }
    public function ali($id)
    {
        $this->db->select('*');
        $this->db->from('sv_videos');
        $this->db->where('id', $id);
        $query = $this->db->get();
        // echo $this->db->last_query();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function aam_id($id)
    {
        $this->db->select('id, video_id, name_id, description_id, thumbnail_id, publish, createdBy, updatedBy');
        $this->db->from('sv_videos');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function aam_labels($id)
    {
        $this->db->select('id, label');
        $this->db->from('sv_labels');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function aam_tags($id)
    {
        $this->db->select('id, tags');
        $this->db->from('sv_tags');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function aam_update($id, $name_id, $description_id, $thumbnail_id, $publish, $user_id)
    {
        $detail = $this->aam_id($id);

        if (!$detail) {
            return false;
        }

        $data = array(
            'name_id' => $name_id,
            'name_en' => $name_id,
            'description_id' => $description_id,
            'description_en' => $description_id,
            'thumbnail_id' => $thumbnail_id,
            'thumbnail_en' => $thumbnail_id,
            'publish' => $publish,
            'updatedAt' => $user_id,
            'updatedAt' => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $id);
        $result = $this->db->update('sv_videos', $data);
        
        echo $this->db->last_query();

        return $result;
    }
    public function save_video_labels($vid, $label_id)
    {
        $array = json_decode($label_id, true);

        if (is_array($array)) {
            $data = [];
            foreach ($array as $v)
            {
                $data[] = ["vid" => $vid, "label_id" => $v, "createdAt" => date('Y-m-d H:i:s')];
            }
            $this->db->delete('sv_video_labels', ['vid' => $vid]);
            $this->db->insert_batch('sv_video_labels', $data);
        } else {
            $data = array(
                'vid' => $vid,
                'label_id' => $label_id,
                'createdAt' => date('Y-m-d H:i:s')
            );
        
            $this->db->insert('sv_video_labels', $data);
        }
        return $this->db->insert_id();
    }
    public function save_video_labels_ali($vid, $label_ids)
    {
        if (!is_array($label_ids)) {
            return false;
        }

        $data = array();
        $currentDateTime = date('Y-m-d H:i:s');

        foreach ($label_ids as $label_id) {
            $data[] = array(
                'vid' => $vid,
                'label_id' => $label_id,
                'createdAt' => $currentDateTime
            );
        }

        $this->db->insert_batch('sv_video_labels', $data);
        echo $this->db->last_query();
        return true; 
    }
    public function save_video_tags($vid, $tag_id)
    {
        $tagArray = json_decode($tag_id, true);
        if (is_array($tagArray) && !empty($tagArray)) {
            $data = [];
            foreach ($tagArray as $v) {
                $data[] = ["vid" => $vid, "tag_id" => $v, "createdAt" => date('Y-m-d H:i:s')];
            }
            var_dump($data);
            $this->db->insert_batch('sv_video_tags', $data);
        } else {
            $data = array(
                'vid' => $vid,
                'tag_id' => $tag_id,
                'createdAt' => date('Y-m-d H:i:s')
            );
            var_dump("p");
            $this->db->insert('sv_video_tags', $data);
        }

        return $this->db->insert_id();
    }
    public function Xaam_update($id, $name_id, $description_id, $thumbnail_id, $publish)
    {
        $detail = $this->aam_id($id);
        $labels = $this->aam_lebels_id($id);

        if (!$video || !$labels) {
            return false;
        }

        $data = array(
            'name_id' => $name_id,
            'name_en' => $name_id,
            'description_id' => $description_id,
            'description_en' => $description_id,
            'thumbnail_id' => $thumbnail_id,
            'thumbnail_en' => $thumbnail_id,
            'publish' => $publish,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        $data_labels = array (
            'vid' => $id,
            'label_id' => $id,
            'updatedAt' => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $id);
        $result = $this->db->update('sv_videos', $data);
        $result = $this->db->insert('sv_videos', $data_labels);
        
        echo $this->db->last_query();

        return $result;
    }
    public function update_data($id, $name_id, $description_id, $publish, $thumbnail_id)
    {
        $data = array(
            'name_id' => $name_id,
            'description_id' => $description_id,
            'publish' => $publish,
            'thumbnail_id' => $thumbnail_id,
            'updatedAt' => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $id);
        $result = $this->db->update('sv_videos', $data);

        return $result;
    }
    public function update_aam($id, $name_id, $description_id, $thumbnail_id)
    {

        $data = array(
            'name_id' => $name_id,
            'description_id' => $description_id,
            'thumbnail_id' => $thumbnail_id,
        );

        $this->db->where('id', $id, $name_id,  $description_id, $thumbnail_id);
        $this->db->update('sv_videos', $data);

        return $this->db->affected_rows() > 0;
    }
    public function update_videod($id, $thumbnail_id)
    {
        $data = array(
            'thumbnail_id' => $thumbnail_id,
        );

        $this->db->where('id', $id);
        $this->db->update('sv_videos', $data);

        if ($this->db->affected_rows() > 0) {
            return array('status' => 'success', 'message' => 'Video updated successfully');
        } else {
            return array('status' => 'error', 'message' => 'Failed to update video');
        }
    }
    public function update_video($id, $thumbnail_id) 
    {
        $data = array(
            'thumbnail_id' => $thumbnail_id,
            'createdAt' => date('Y-m-d H:i:s')
        );

        $insert_result = $this->db->where('id', $id);
        $insert_result = $this->db->update('sv_videos', $data);

        if ($insert_result) {
            return ['status' => 'success', 'message' => 'Video information saved successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Failed to save video information'];
        }
    }
    public function updateVideo($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('sv_videos', $data);
    }
    public function edit_video_details($id, $data)
    {

        $updateQuery = "UPDATE videos SET
                        video_id = :video_id,
                        -- video_en = :video_en,
                        name_id = :name_id,
                        -- name_en = :name_en,
                        description_id = :description_id,
                        -- description_en = :description_en,
                        updatedAt = NOW(),
                        thumbnail_id = :thumbnail_id
                        WHERE id = :id";

        $statement = $this->db->prepare($updateQuery);

        $statement->bindParam(':video_id', $data['video_id']);
        $statement->bindParam(':name_id', $data['name_id']);
        $statement->bindParam(':description_id', $data['description_id']);
        $statement->bindParam(':thumbnail_id', $data['thumbnail_id']);
        $statement->bindParam(':id', $id);

        $success = $statement->execute();

        echo $this->db->last_query();

        if ($success) {
            return $this->get_detail_video_by_id($id);
        } else {
            return false;
        }
    }
    public function test($id, $name_id, $description_id, $publish) 
    {
        $data = array(
            'name_id' => $name_id,
            'description_id' => $description_id,
            'publish' => $publish,
            'updatedAt' => date('Y-m-d H:i:s')
        );
    
        $this->db->where('id', $id);
        $update_result = $this->db->update('sv_videos', $data);
    
        echo $this->db->last_query();
    
        if ($update_result) {
            return ['status' => 'success', 'message' => 'Video information updated successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Failed to update video information'];
        }
    }
    public function update_datadata($id, $name_id, $description_id, $publish, $thumbnail_id) 
    {
        $data = array(
            'name_id' => $name_id,
            'description_id' => $description_id,
            'publish' => $publish,
            'thumbnail_id' => $thumbnail_id,
            'updatedAt' => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $id);
        echo $this->db->last_query();

        $result = $this->db->update('sv_videos', $data);

        return $result;
    }
    public function get_labels() 
    {
        $this->db->select('id, label');
        $query = $this->db->get('sv_labels');
    
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function get_tags()
    {
        $this->db->select('id, tags');
        $query = $this->db->get('sv_tags');
    
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function aam_lebels_id($id)
    {
        $this->db->select('id, label');
        $this->db->from('sv_labels');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function aam_update_label($id)
    {
        $video = $this->aam_id($id);
        $labels = $this->aam_lebels_id($id);

        if (!$video || !$labels) {
            return false;
        }

        $data = array(
            'sv_video_id' => $video,
            'sv_label_id' => $labels,
            'updatedAt' => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $id);
        $result = $this->db->insert('sv_video_labels', $data);
        
        echo $this->db->last_query();

        return $result;
    }
    public function get_profil_detail($id)
    {
        $this->db->select('*');
        $this->db->from('sv_users');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function update_profil_detail($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('sv_users', $data);

        return $this->db->affected_rows() > 0;
    }
    public function verify_login($username, $password)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('sv_admin');

        if ($query->num_rows() > 0) {
            $user = $query->row_array();
            return password_verify($password, $user['password']);
        }

        return false;
    }
    public function check_email_exists($email)
    {
        $this->db->where('username', $email);
        $query = $this->db->get('sv_admin');
        return $query->num_rows() > 0;
    }
    public function register_user($data) 
    {
        $data['id_admin_grup'] = 5;

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        return $this->db->insert('sv_admin', $data);
    }
    public function get_user_by_username($username) 
    {
        $this->db->where('username', $username);
        $query = $this->db->get('sv_admin');
        return $query->row_array();
    }
    public function getVideoByCreatedBy($createdBy)
    {
        $this->db->select('id, name_id');
        $this->db->where('createdBy', $createdBy);
        $query = $this->db->get('sv_videos');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function getVideoBy($createdBy) 
    {
        $this->db->select('vrh.*, vrh.id, vrh.parent_id, vrh.uid, vrh.vid, v.createdBy, v.thumbnail_id, v.name_id, u.full_name, u.email, u.birthdate, u.phone, u.address, c.city_name, u.zip_code');
        $this->db->from('sv_video_reviews_history vrh');
        $this->db->join('sv_users u', 'u.id = vrh.uid', 'left');
        $this->db->join('sv_videos v', 'v.id = vrh.vid', 'left');
        $this->db->join('sv_cities c', 'c.id = u.id', 'left');
        $this->db->select("YEAR(CURDATE()) - YEAR(u.birthdate) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(u.birthdate, '%m%d')) AS age", false);
        $this->db->where('u.id', $createdBy);
        $this->db->order_by('vrh.createdAt', 'DESC');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    public function count_watch_history_last_30_days($createdBy) 
    {
        $this->db->select('v.createdBy, COUNT(*) AS last_watch_chanel');
        $this->db->from('sv_watch_history AS wh');
        $this->db->join('sv_videos AS v', 'wh.vid = v.id');
        $this->db->where('wh.createdAt >=', date('Y-m-d', strtotime('-30 days')));
        $this->db->where('v.createdBy', $createdBy);
        $this->db->group_by('v.createdBy');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function count_all_watch($createdBy) 
    {
        $this->db->select('v.createdBy, COUNT(*) AS count_all_watch');
        $this->db->from('sv_watch_history AS wh');
        $this->db->join('sv_videos AS v', 'wh.vid = v.id');
        $this->db->where('v.createdBy', $createdBy);
        $this->db->group_by('v.createdBy');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function calculate_average_watch_count($createdBy) 
    {
        $this->db->select('COUNT(DISTINCT wh.vid) AS total_videos_watched');
        $this->db->from('sv_watch_history AS wh');
        $this->db->join('sv_videos AS v', 'wh.vid = v.id');
        $this->db->where('v.createdBy', $createdBy);
        $query = $this->db->get();
        $total_videos_watched = $query->row()->total_videos_watched;

        $this->db->select('COUNT(DISTINCT wh.uid) AS total_unique_users');
        $this->db->from('sv_watch_history AS wh');
        $this->db->join('sv_videos AS v', 'wh.vid = v.id');
        $this->db->where('v.createdBy', $createdBy);
        $query = $this->db->get();
        $total_unique_users = $query->row()->total_unique_users;
        echo $this->db->last_query();

        if ($total_unique_users > 0) {
            $average_watch_count = $total_videos_watched / $total_unique_users;
            return $average_watch_count;
        } else {
            return false;
        }
    }
    public function getUserById($id) 
    {
        return $this->db->get_where('sv_users', array('id' => $id))->row();
    }
    public function getUserWithTokenById($token_contributor)
    {
        $this->db->select('token_contributor, device_id, app_key, status, browser_id, md');
        $this->db->where('token_contributor', $token_contributor);
        $query = $this->db->get('sv_users');
    
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    public function getCheck()
    {
        $this->db->select('*');
        $this->db->from('sv_users');
        $this->db->where("SUBSTRING_INDEX(token_contributor, -1) != ''");
        $this->db->where('token_contributor');
        return $this->db->get()->row();
    }
    public function updateTokenContributor($id, $token_contributor) 
    {
        $token_parts = explode("#", $token_contributor);

        $token_contributor = isset($token_parts[0]) ? $token_parts[0] : null;
        $device_id = isset($token_parts[1]) ? $token_parts[1] : null;
        $app_key = isset($token_parts[2]) ? $token_parts[2] : null;

        $data = array(
            'token_contributor' => $token_contributor,
            'device_id' => $device_id,
            'app_key' => $app_key
        );

        $this->db->where('id', $id);

        $this->db->update('sv_users', $data);
    }
    public function deleteTokenContributor($id) 
    {
        $data = array(
            'token_contributor' => null,
            'device_id' => null,
            'app_key' => null
        );

        $this->db->where('id', $id);
        $this->db->update('sv_users', $data);
    }
    public function getBrowserId($user_id)
    {
        $query = $this->db->select('browser_id')
                          ->from('sv_users')
                          ->where('id', $user_id)
                          ->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->browser_id;
        } else {
            return null;
        }
    }
    public function getDeviceId($user_id)
    {
        $query = $this->db->select('device_id')
                          ->from('sv_users')
                          ->where('id', $user_id)
                          ->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->device_id;
        } else {
            return null;
        }
    }
    public function getTokenId($user_id)
    {
        $query = $this->db->select('token_contributor')
                          ->from('sv_users')
                          ->where('id', $user_id)
                          ->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->token_contributor;
        } else {
            return null;
        }
    }
    public function getMacId($user_id)
    {
        $query = $this->db->select('md')
                          ->from('sv_users')
                          ->where('id', $user_id)
                          ->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->md;
        } else {
            return null;
        }
    }
    public function getAppKeyId($user_id)
    {
        $query = $this->db->select('app_key')
                          ->from('sv_users')
                          ->where('id', $user_id)
                          ->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->app_key;
        } else {
            return null;
        }
    }
    public function getStatusId($user_id)
    {
        $query = $this->db->select('status')
                          ->from('sv_users')
                          ->where('id', $user_id)
                          ->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->status;
        } else {
            return null;
        }
    }
    public function getTokenContributor($id)
    {
        // Gantilah 'nama_tabel' dengan nama tabel yang sesuai di database Anda
        $this->db->select('token_contributor');
        $this->db->where('id', $id);
        $query = $this->db->get('sv_users');
    
        if($query->num_rows() > 0) {
            $row = $query->row();
            return $row->token_contributor;
        } else {
            return null; // Mengembalikan null jika tidak ada data dengan id yang diberikan
        }
    }
    public function updateTokenContributorNew($id, $decoded_token_contributor)
    {
        $token_parts = explode("#", $decoded_token_contributor);
    
        // Menentukan nilai untuk setiap bagian token atau mengatur nilai default menjadi null
        $md = isset($token_parts[1]) ? $token_parts[1] : null;
        $decoded_token_contributor = isset($token_parts[0]) ? $token_parts[0] : null;
        $browser_id = isset($token_parts[2]) ? $token_parts[2] : null;
        $device_id = isset($token_parts[3]) ? $token_parts[3] : null;
        $app_key = isset($token_parts[4]) ? $token_parts[4] : null;
        // $user_id = isset($token_parts[5]) ? $token_parts[5] : null;
    
        // Menyiapkan data untuk di-update
        $data = array(
            'token_contributor' => $decoded_token_contributor,
            'md' => $md,
            'browser_id' => $browser_id,
            'device_id' => $device_id,
            'app_key' => $app_key,
            'status' => 'Online'
            // 'user_id' => $user_id // Jika perlu diaktifkan, sesuaikan nilai default dan kolom yang sesuai
        );
    
        // Menggunakan ID yang diterima sebagai kondisi untuk memperbarui data
        $this->db->where('id', $id);
        $this->db->update('sv_users', $data);
    }
}