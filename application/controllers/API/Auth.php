<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Model_api');
        $this->load->library('response');
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->output->set_status_header(405);
            echo json_encode(['error' => 'Metode HTTP tidak diizinkan.']);
            return;
        }
    
        $input = json_decode(file_get_contents('php://input'), true);
    
        $username = isset($input['username']) ? $input['username'] : '';
        $password = isset($input['password']) ? $input['password'] : '';
    
        if (!$username || !$password) {
            $this->output->set_status_header(400);
            echo json_encode(['error' => 'Username dan password harus diisi.']);
            return;
        }
    
        $result = $this->Model_api->verify_login($username, $password);
    
        if ($result) {
            $this->output->set_status_header(200);
            echo json_encode(['success' => 'Login berhasil.']);
        } else {
            $this->output->set_status_header(401);
            echo json_encode(['error' => 'Username atau password salah.']);
        }
    }
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->output->set_status_header(405);
            echo json_encode(['error' => 'Metode HTTP tidak diizinkan.']);
            return;
        }
    
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $name = $this->input->post('name');
    
        if (!$username || !$password || !$name) {
            $this->output->set_status_header(400);
            echo json_encode(['error' => 'Semua field harus diisi.']);
            return;
        }
    
        $email_exists = $this->Model_api->check_email_exists($username);
        if ($email_exists) {
            $this->output->set_status_header(400);
            echo json_encode(['error' => 'Email sudah terdaftar.']);
            return;
        }
    
        $data = array(
            'username' => $username,
            'password' => md5($password),
            'name' => $name
        );
    
        $result = $this->Model_api->register_user($data);
    
        if ($result) {
            $inserted_data = $this->Model_api->get_user_by_username($username);
    
            $this->output->set_status_header(201);
            echo json_encode(['success' => 'Registrasi berhasil', 'data' => $inserted_data]);
        } else {
            $this->output->set_status_header(500);
            echo json_encode(['error' => 'Registrasi gagal. Silakan coba lagi.']);
        }
    }
    public function cekToken() {
        $id = '3834';
        $token_contributor = $this->input->post('token_contributor');
    
        $user_data = $this->Model_api->getUserWithTokenById($token_contributor);
    
        if ($user_data) {
            $response = array(
                'status' => 'success',
                'message' => 'Token Valid',
                'user_id' => $id,
                'token_contributor' =>  $this->Model_api->getTokenId($id),
                'md' =>  $this->Model_api->getMacId($id),
                'browser_id' =>  $this->Model_api->getBrowserId($id),
                'device_id' => $this->Model_api->getDeviceId($id),
                'app_key' => $this->Model_api->getAppKeyId($id),
                'status_log' => $this->Model_api->getStatusId($id)
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Token Tidak Valid',
                'user_id' => $id,
                'token_contributor' => null,
                'device_id' => null,
                'app_key' => null,
                'status_log' => 'offline'
            );
        }
    
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function check() {
        $id = '9767';
        // Mengambil nilai input dari POST
        $token_contributor = $this->input->post('token_contributor');
        $md_input = $this->input->post('md');
        $browser_id_input = $this->input->post('browser_id');
        $device_id_input = $this->input->post('device_id');
        $app_key_input = $this->input->post('app_key');
        // $status_log_input = $this->input->post('status_log');
    
        // Memeriksa apakah nilai input sama dengan nilai di database
        $user_data = $this->Model_api->getUserWithTokenById($token_contributor);
    
        if ($user_data) {
            $md_db = $this->Model_api->getMacId($id);
            $browser_id_db = $this->Model_api->getBrowserId($id);
            $device_id_db = $this->Model_api->getDeviceId($id);
            $app_key_db = $this->Model_api->getAppKeyId($id);
            $status_log_db = $this->Model_api->getStatusId($id);
    
            // Membandingkan nilai input dengan nilai di database
            if ($md_input === $md_db && $browser_id_input === $browser_id_db && $device_id_input === $device_id_db && $app_key_input === $app_key_db) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Data Valid',
                    'user_id' => $id,
                    'token_contributor' => $token_contributor,
                    'md' => $md_input,
                    'browser_id' => $browser_id_input,
                    'device_id' => $device_id_input,
                    'app_key' => $app_key_input,
                    'status_log' => $status_log_db
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Data Tidak Valid',
                    'user_id' => $id,
                    'token_contributor' => $token_contributor,
                    'md' => $md_input,
                    'browser_id' => $browser_id_input,
                    'device_id' => $device_id_input,
                    'app_key' => $app_key_input,
                    'status_log' => $status_log_db
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Token Tidak Valid',
                'user_id' => $id,
                'token_contributor' => null,
                'md' => null,
                'browser_id' => null,
                'device_id' => null,
                'app_key' => null,
                'status_log' => 'offline'
            );
        }
    
        // Mengirim respons dalam format JSON
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function scanQr()
    {
        $id = '9767';
        $encoded_token_contributor = $this->input->post('token_contributor');
        // $browser_id = $this->Model_api->getBrowserId();
        // $device_id = $this->Model_api->getDeviceId();

        // Validasi jika data yang dikirimkan kosong
        if (empty($encoded_token_contributor)) {
            $response = array(
                'status_code' => 400,
                'status' => 'error',
                'message' => 'Tidak Ada Data Yang Di Kirim',
            );
            $status_code = 400;
        } else {
            // Mendekode token_contributor
            $decoded_token_contributor = base64_decode($encoded_token_contributor);
            // echo $encoded_token_contributor;

            // Mendapatkan nilai token_contributor dari database
            $current_token_contributor = $this->Model_api->getTokenContributor($id);

            // Jika nilai token_contributor dari database adalah null, lakukan update
            if ($current_token_contributor === null) {
                $this->Model_api->updateTokenContributorNew($id, $decoded_token_contributor);
                $response = array(
                    'status_code' => 200,
                    'status' => 'success',
                    'message' => 'Token updated Berhasil',
                    'user_id' => $id,
                    'token_contributor' =>  $this->Model_api->getTokenId($id),
                    'md' =>  $this->Model_api->getMacId($id),
                    'browser_id' =>  $this->Model_api->getBrowserId($id),
                    'device_id' => $this->Model_api->getDeviceId($id),
                    'app_key' => $this->Model_api->getAppKeyId($id),
                    'status' => $this->Model_api->getStatusId($id),
                );
                $status_code = 200;
            } else {
                // Jika nilai yang diinputkan sama dengan nilai token_contributor
                if ($decoded_token_contributor === $decoded_token_contributor) {
                    $response = array(
                        'status_code' => 400,
                        'status' => 'error',
                        'message' => 'Sudah Login di '.$this->Model_api->getBrowserId($id). ', Silahkan Logout dulu',
                        'user_id' => $id,
                        'browser_id' =>  $this->Model_api->getBrowserId($id),
                        'device_id' => $this->Model_api->getDeviceId($id),
                        'status' => $this->Model_api->getStatusId($id),
                    
                    );
                    $status_code = 400;
                } else {
                    // Jika nilai yang diinputkan tidak sama dengan nilai token_contributor
                    $response = array(
                        'status_code' => 400,
                        'status' => 'error',
                        'message' => 'Invalid data',
                    );
                    $status_code = 400;
                }
            }
        }

        $this->output->set_status_header($status_code)->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function logout() {
        $id = $this->input->post('id');

        $this->Model_api->deleteTokenContributor($id);

        $response = array(
            'status_code' => 200,
            'status' => 'success',
            'message' => 'Logout successful',
            // 'id' => $id
        );

        $status_code = 200;
        $this->output->set_status_header($status_code)->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function signout($id) {
        $this->Model_api->deleteTokenContributor($id);

        $response = array(
            'status_code' => 200,
            'status' => 'success',
            'message' => 'Logout successful',
            'id' => $id 
        );

        $status_code = 200; 

        $this->output->set_status_header($status_code)->set_content_type('application/json')->set_output(json_encode($response));
    }
}