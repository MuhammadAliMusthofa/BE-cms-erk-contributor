<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chart extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Model_api');
        $this->load->library('response');
    }

    public function Xpenayangan() {
        $penayangan = $this->Model_api->get_penayangan();
        if ($penayangan) {
            $formatted_penayangan = array();
    
            foreach ($penayangan as $record) {
                $gender = (rand(0, 1) == 0) ? 'pria' : 'wanita';
    
                // Mendapatkan nilai acak untuk tanggal antara 1 Januari 2022 dan 31 Desember 2023
                $random_date = date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31')));
    
                $formatted_record = array(
                    'id' => $gender,
                    'color' => 'dark greenAccent-500',
                    'data' => array(
                        array(
                            'x' => $random_date,
                            'y' => rand(40, 60),
                        ),
                    ),
                );
                $formatted_penayangan[] = $formatted_record;
            }
            $this->response->json($formatted_penayangan, 200); 
        } else {
            $this->response->json(['error' => 'No penayangan found'], 404); 
        }
    }
    public function penayangan() {
        $penayangan = $this->Model_api->get_penayangan();
        if ($penayangan) {
            $formatted_penayangan = array();

            $female_data = array_slice($penayangan, 1, 1);
            foreach ($female_data as $record) {
                $formatted_record = array(
                    'id' => 'Wanita',
                    'color' => '#4CAF50',
                    'data' => array(
                        array(
                            'x' => '2024-01-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            'x' => '2024-01-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            'x' => '2024-02-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            'x' => '2024-02-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            'x' => '2024-02-29',
                            'y' => rand(20, 250),
                        ),
                    ),
                );
                $formatted_penayangan[] = $formatted_record;
            }
            
            $male_data = array_slice($penayangan, 1, 1); 
            foreach ($male_data as $record) {
                $formatted_record = array(
                    'id' => 'Pria',
                    'color' => '#2196F3',
                    'data' => array(
                        array(
                            'x' => '2024-01-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            'x' => '2024-01-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            'x' => '2024-02-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            'x' => '2024-02-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            'x' => '2024-02-29',
                            'y' => rand(20, 250),
                        ),
                    ),
                );
                $formatted_penayangan[] = $formatted_record;
            }
    
            $this->response->json($formatted_penayangan, 200); 
        } else {
            $this->response->json(['error' => 'No penayangan found'], 404); 
        }
    }
    public function uniq() {
        $penayangan = $this->Model_api->get_penayangan();
        if ($penayangan) {
            $formatted_penayangan = array();

            $female_data = array_slice($penayangan, 1, 1);
            foreach ($female_data as $record) {
                $formatted_record = array(
                    'id' => 'Wanita',
                    'color' => '#4CAF50',
                    'data' => array(
                        array(
                            'x' => '2024-01-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            'x' => '2024-01-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            'x' => '2024-02-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            'x' => '2024-02-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            'x' => '2024-02-29',
                            'y' => rand(20, 250),
                        ),
                    ),
                );
                $formatted_penayangan[] = $formatted_record;
            }
            
            $male_data = array_slice($penayangan, 1, 1); 
            foreach ($male_data as $record) {
                $formatted_record = array(
                    'id' => 'Pria',
                    'color' => '#2196F3',
                    'data' => array(
                        array(
                            'x' => '2024-01-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-01-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-29',
                            'y' => rand(20, 250),
                        ),
                    ),
                );
                $formatted_penayangan[] = $formatted_record;
            }
    
            $this->response->json($formatted_penayangan, 200); 
        } else {
            $this->response->json(['error' => 'No penayangan found'], 404); 
        }
    }
    public function rewatch() {
        $penayangan = $this->Model_api->get_penayangan();
        if ($penayangan) {
            $formatted_penayangan = array();

            $female_data = array_slice($penayangan, 1, 1);
            foreach ($female_data as $record) {
                $formatted_record = array(
                    'id' => 'Wanita',
                    'color' => '#4CAF50',
                    'data' => array(
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-01-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-01-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-29',
                            'y' => rand(20, 250),
                        ),
                    ),
                );
                $formatted_penayangan[] = $formatted_record;
            }
            
            $male_data = array_slice($penayangan, 1, 1); 
            foreach ($male_data as $record) {
                $formatted_record = array(
                    'id' => 'Pria',
                    'color' => '#2196F3',
                    'data' => array(
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-01-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-01-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-29',
                            'y' => rand(20, 250),
                        ),
                    ),
                );
                $formatted_penayangan[] = $formatted_record;
            }
    
            $this->response->json($formatted_penayangan, 200); 
        } else {
            $this->response->json(['error' => 'No penayangan found'], 404); 
        }
    }
    public function watchduration() {
        $penayangan = $this->Model_api->get_penayangan();
        if ($penayangan) {
            $formatted_penayangan = array();

            $female_data = array_slice($penayangan, 1, 1);
            foreach ($female_data as $record) {
                $formatted_record = array(
                    'id' => 'Wanita',
                    'color' => '#4CAF50',
                    'data' => array(
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-01-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-01-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-29',
                            'y' => rand(20, 250),
                        ),
                    ),
                );
                $formatted_penayangan[] = $formatted_record;
            }
            
            $male_data = array_slice($penayangan, 1, 1); 
            foreach ($male_data as $record) {
                $formatted_record = array(
                    'id' => 'Pria',
                    'color' => '#2196F3',
                    'data' => array(
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-01-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-01-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-29',
                            'y' => rand(20, 250),
                        ),
                    ),
                );
                $formatted_penayangan[] = $formatted_record;
            }
    
            $this->response->json($formatted_penayangan, 200); 
        } else {
            $this->response->json(['error' => 'No penayangan found'], 404); 
        }
    }
    public function watchtime() {
        $penayangan = $this->Model_api->get_penayangan();
        if ($penayangan) {
            $formatted_penayangan = array();

            $female_data = array_slice($penayangan, 1, 1);
            foreach ($female_data as $record) {
                $formatted_record = array(
                    'id' => 'Wanita',
                    'color' => '#4CAF50',
                    'data' => array(
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-01-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-01-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-29',
                            'y' => rand(20, 250),
                        ),
                    ),
                );
                $formatted_penayangan[] = $formatted_record;
            }
            
            $male_data = array_slice($penayangan, 1, 1); 
            foreach ($male_data as $record) {
                $formatted_record = array(
                    'id' => 'Pria',
                    'color' => '#2196F3',
                    'data' => array(
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-01-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-01-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-29',
                            'y' => rand(20, 250),
                        ),
                    ),
                );
                $formatted_penayangan[] = $formatted_record;
            }
    
            $this->response->json($formatted_penayangan, 200); 
        } else {
            $this->response->json(['error' => 'No penayangan found'], 404); 
        }
    }
    public function subscribe() {
        $penayangan = $this->Model_api->get_penayangan();
        if ($penayangan) {
            $formatted_penayangan = array();

            $female_data = array_slice($penayangan, 1, 1);
            foreach ($female_data as $record) {
                $formatted_record = array(
                    'id' => 'Wanita',
                    'color' => '#4CAF50',
                    'data' => array(
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-01-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-01-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-29',
                            'y' => rand(20, 250),
                        ),
                    ),
                );
                $formatted_penayangan[] = $formatted_record;
            }

            
            
            $male_data = array_slice($penayangan, 1, 1); 
            foreach ($male_data as $record) {
                $formatted_record = array(
                    'id' => 'Pria',
                    'color' => '#2196F3',
                    'data' => array(
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-01-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-01-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-01',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-15',
                            'y' => rand(20, 250),
                        ),
                        array(
                            // 'x' => date('d M Y', rand(strtotime('2022-01-01'), strtotime('2023-12-31'))),
                            'x' => '2024-02-29',
                            'y' => rand(20, 250),
                        ),
                    ),
                );
                $formatted_penayangan[] = $formatted_record;
            }
    
            $this->response->json($formatted_penayangan, 200); 
        } else {
            $this->response->json(['error' => 'No penayangan found'], 404); 
        }
    }
}