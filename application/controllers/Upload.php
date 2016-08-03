<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller
{
	public $alert = [
			'success' => 'All file uploaded successfully',
			'error' => 'Sorry something gone wrong with upload, please contact the admin',
			'fatal' => '',
		];
		
	public $configuration = [
			'upload_path' => 'uploads/file/',
			'allowed_types' => 'gif|jpg|png',
			'encrypt_name' => TRUE
		];
	
	public $fileNames = [];
	
	
	public function  __construct() 
	{
		parent::__construct();
		$this->load->model('arquivo_model');
		$this->load->library(['upload']);
		$this->load->helper(['form', 'url']);
	}
	
	
	public function index()
	{

		$this->load->view('index');
	}
	
	/*
	* Função de entrada dos dados
	* 
	* @return void
	*/
	public function config_upload()
	{
		$data = array();
		var_dump($this->upload->hasFile('userFile'));
		die();
		if ($this->upload->hasFile('userFile')) {
			
			$filesCount = count($_FILES['userFiles']['name']);
			$files = $_FILES['userFile'];
			
			for($i = 0; $i < $filesCount; $i++){
				$_FILES['userFile']['name'] = $files['name'][$i];
				$_FILES['userFile']['type'] = $files['type'][$i];
				$_FILES['userFile']['tmp_name'] = $files['tmp_name'][$i];
				$_FILES['userFile']['error'] = $files['error'][$i];
				$_FILES['userFile']['size'] = $files['size'][$i];

				//TODO: Verificar nesta etapa se todos os arquivos enviados estao sendo validados pela função do_upload.
				if (!$this->do_upload()) {
					log_message($this->upload->display_errors().": ".date('d/m/Y H:m:s')); // salva um registro no arquivo de log com o erro.
					$this->session->set_flashdata('statusMsg', $this->alert["error"]);
					$this->load->view('index');
				}
			}
		}
		if (!$this->arquivo_model->insert($this->fileNames)) {
			$this->session->set_flashdata('statusMsg', $this->alert["error"]);
			$this->load->view('index');
		}
		
		$this->session->set_flashdata('statusMsg', $this->alert["success"]);
		$this->load->view('index');
	}
	/*
	* Realiza o upload dos arquivos (1 por vez)
	*
	* @return bool
	*/
	public function do_upload()
	{
		$this->upload->initialize($this->configuration);
		
		if (!$this->upload->do_upload('userFile')) {
			return FALSE;
		}
		
		// Salva o nome do arquivo em um array para ser salvo no banco posteriormente
		array_push($this->fileNames, $this->upload->data('file_name')); 
		return TRUE;
	}
}