<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Capaian_pembelajaran extends CI_Controller {
	
		var $utama ='capaian_pembelajaran';
		var $title ='Capaian Pembelajaran';
	function __construct()
	{
		parent::__construct();
                izin();
		$this->load->library('flexigrid');
        $this->load->helper('flexigrid');
		$this->load->model('Chart_model');
	}
	
	function index()
	{
		$this->main();
	}
	function main()
	{
            $data['type']='View';
			$data['content'] = 'contents/'.$this->utama.'/view';

			$data['get_cp']= $this->Chart_model->get_all_cp();
            $data['jenjang_options'] = $this->Chart_model->getJenjangOptions();
			
			
			$this->load->view('layout/main',$data);
	}
    
	public function view_cp($id) {
        $data['cp'] = $this->Chart_model->get_cp_by_id($id);
        // Load view and pass $data
    }

    public function add_cp() {
    $cpDir = './assets/ace/cp/';
    if (!is_dir($cpDir)) {
        mkdir($cpDir, 0777, TRUE);
    }

    $config['upload_path'] = $cpDir;
    $config['allowed_types'] = 'pdf';
    $config['max_size'] = 2048;
    $this->load->library('upload', $config);

    // Mendapatkan jumlah file yang diunggah
    $number_of_files = count($_FILES['pdf_files']['name']);

    // Proses upload untuk setiap file
    for ($i = 0; $i < $number_of_files; $i++) {
        $_FILES['userfile']['name'] = $_FILES['pdf_files']['name'][$i];
        $_FILES['userfile']['type'] = $_FILES['pdf_files']['type'][$i];
        $_FILES['userfile']['tmp_name'] = $_FILES['pdf_files']['tmp_name'][$i];
        $_FILES['userfile']['error'] = $_FILES['pdf_files']['error'][$i];
        $_FILES['userfile']['size'] = $_FILES['pdf_files']['size'][$i];

        if ($this->upload->do_upload('userfile')) {
            $upload_data = $this->upload->data();
            $data = array(
                'deskripsi' => $this->input->post('deskripsi'),
                'judul' => $this->input->post('judul'),
                'jenjang' => $this->input->post('jenjang'),
                'link' => 'assets/ace/cp/' . $upload_data['file_name'],
                'createdAt' => date('Y-m-d H:i:s')
            );
            $this->Chart_model->add_cp($data);
        } else {
            $error = array('error' => $this->upload->display_errors());
            // Lakukan sesuatu dengan error jika diperlukan
        }
    }
    redirect($this->utama);
}

    public function update_cp($id) {
        if ($this->input->post()) {
            $cpDir = './assets/ace/cp/';
            if (!is_dir($cpDir)) {
                mkdir($cpDir, 0777, TRUE);
            }
            
            $config['upload_path'] = $cpDir;
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 2048;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('edit_pdf_file')) {
                $upload_data = $this->upload->data();
                $data = array(
                    'deskripsi' => $this->input->post('edit_deskripsi'),
                    'judul' => $this->input->post('edit_judul'),
                    'jenjang' => $this->input->post('edit_jenjang'),
                    'link' => 'assets/ace/cp/' . $upload_data['file_name'],
                    'updatedAt' => date('Y-m-d H:i:s')
                );
            } else {
                $data = array(
                    'deskripsi' => $this->input->post('edit_deskripsi'),
                    'judul' => $this->input->post('edit_judul'),
                    'jenjang' => $this->input->post('edit_jenjang'),
                    'updatedAt' => date('Y-m-d H:i:s')
                );
            }

            $this->load->model('Chart_model');
            $this->Chart_model->update_cp($id, $data);

            redirect($this->utama);
        } else {
            redirect($this->utama);
        }
    }

    public function deletec($id) {
        $this->Chart_model->delete_cp($id);
       redirect($this->utama);
    }
    
        
}
?>