<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Apps_versions extends CI_Controller {
	
		var $utama ='apps_versions';
		var $title ='Mobile Version';
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

			$data['get_android']= $this->Chart_model->get_android();
			$data['get_ios']= $this->Chart_model->get_ios();
            $data['jenjang_options'] = $this->Chart_model->getJenjangOptions();
			
			
			$this->load->view('layout/main',$data);
	}
    
	public function view_cp($id) {
        $data['cp'] = $this->Chart_model->get_cp_by_id($id);
    }

    public function add_versions()
    {
        $versions = $this->input->post('versions');
        $type = $this->input->post('type');
        $description = $this->input->post('description');

        // Proses validasi data (sesuaikan dengan kebutuhan Anda)

        // Simpan data ke database menggunakan model
        $data = array(
            'versions' => $versions,
            'type' => $type,
            'description' => $description
        );
        $this->Chart_model->add_version($data); // Ganti 'Your_model' dengan nama model Anda

        // Redirect ke halaman yang sesuai setelah proses selesai
        redirect($this->utama);
    }

    public function deletec($id) {
        $this->Chart_model->delete_ver($id);
        redirect($this->utama);
    }     
}
?>