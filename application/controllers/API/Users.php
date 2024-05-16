<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Model_api');
        $this->load->library('response');
    }

    public function count() {
        $countusers = $this->Model_api->getcountusers();
        $data['countusers'] = $countusers;

        json_encode($countusers);

        $this->response->json([
            'countusers' => $countusers
        ], 200);
    }

    public function list_subscribe(){
        $detail = $this->Model_api->get_list_users();
        
        if ($detail) {
            $formatted_detail = array();
    
            foreach ($detail as $subscribe) {
                $first_letter = strtoupper(substr($subscribe['full_name'], 0, 1));
    
                $formatted_subscribe = array(
                    'id' => $subscribe['id'],
                    'imgAvatar' => "https://example.com/avatar?initial=$first_letter&background=blue", // Ganti dengan URL sesuai kebutuhan Anda
                    'full_name' => isset($subscribe['full_name']) ? $subscribe['full_name'] : 'No Name available',
                    'email' => isset($subscribe['email']) ? $subscribe['email'] : 'No email available',
                    'address' => isset($subscribe['address']) ? $subscribe['address'] : 'No address available',
                    'city' => isset($subscribe['city_name']) ? $subscribe['city_name'] : 'No city available',
                    'createdAt' => isset($subscribe['createdAt']) ? $subscribe['createdAt'] : 'No createdAt available'
                );
            
                $formatted_detail[] = $formatted_subscribe;
            }
    
            $this->response->json($formatted_detail, 200);
        } else {
            $this->response->json(['error' => 'No videos found'], 404);
        }
    }

    public function profil($id)
    {
        $detail = $this->Model_api->get_profil_detail($id);
        
        if ($detail) {
            $formatted_detail = array();

            $formatted_profil = array(
                'id' => $detail['id'],
                'full_name' => isset($detail['full_name']) ? $detail['full_name'] : 'No full_name available',
                'phone' => isset($detail['phone']) ? $detail['phone'] : 'No phone available',
                'email' => isset($detail['email']) ? $detail['email'] : 'No email available',
                'address' => isset($detail['address']) ? $detail['address'] : 'No alamat available',
                'avatar' => "https://10.1.4.41/erklika-cms-2/assets/upload_avatar/" . (isset($detail['avatar']) ? $detail['avatar'] : 'No Avatar available')
            );

            $formatted_detail[] = $formatted_profil;
            
            $this->response->json($formatted_detail, 200);
        } else {
            $this->response->json(['error' => 'No videos found'], 404);
        }
    }
    public function update_profil($id)
    {
        $user_details = $this->Model_api->get_profil_detail($id);

        if ($user_details) {
            $avatar = $this->uploadFileAvt('avatar', $id);

            $update_data = array(
                'full_name' => $this->input->post('full_name'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address')
            );

            if ($avatar) {
                $update_data['avatar'] = $avatar;
            }

            $updated = $this->Model_api->update_profil_detail($id, $update_data);

            if ($updated) {
                $this->response->json(['message' => 'Profil berhasil diperbarui'], 200);
            } else {
                $this->response->json(['error' => 'Gagal memperbarui profil'], 500);
            }
        } else {
            $this->response->json(['error' => 'Pengguna tidak ditemukan'], 404);
        }
    }

    private function uploadFileAvt($field_name, $video_id) {
        $config['upload_path'] = './assets/upload_avatar/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name'] = date("mdYiHs");

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($field_name)) {
            // Menangani kegagalan upload
            $error = $this->upload->display_errors();
            return false;
        } else {
            // Upload berhasil
            $upload_data = $this->upload->data();
            return $upload_data['file_name'];
        }
    }
}