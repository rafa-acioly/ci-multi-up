<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller
{
	/**
	 * 
	 * Storage the encrypt name of files 
	 * 
	 */
	public $fileNames = [];
	
	/**
	 * 
	 * Define the key sended on $_FILES
	 *
	 */
	public $key = 'userFile';
	
	
	/**
	 * 
	 * Define the messages for sessions
	 * 
	 */
	public $alert = [
			'success' => 'All file uploaded successfully',
			'error' => 'Sorry something gone wrong with upload, please contact the admin',
			'fatal' => '',
		];
	
	/**
	 * 
	 * Set the configuration for uploaded files
	 * 
	 */ 
	public $configuration = [
			'upload_path' => 'uploads/file/',
			'allowed_types' => 'gif|jpg|png',
			'encrypt_name' => TRUE
		];
	
	public function  __construct() 
	{
		parent::__construct();
		$this->load->model('arquivo_model');
		$this->load->library(['upload']);
		$this->load->helper(['form', 'url']);
	}
	
	/**
	 * 
	 * Call the main view
	 * 
	 */
	public function index()
	{

		$this->load->view('index');
	}
	
	/**
	 * 
	 * Perform loop to upload files if any key is defined
	 * 
	 */
	public function do_upload()
	{
		if ($this->upload->hasFile($this->key)) {
			
			$filesCount = count($_FILES[$this->key]['name']);
			$files = $_FILES[$this->key];
			
			for($i = 0; $i < $filesCount; $i++){
				$_FILES[$this->key]['name'] = $files['name'][$i];
				$_FILES[$this->key]['type'] = $files['type'][$i];
				$_FILES[$this->key]['tmp_name'] = $files['tmp_name'][$i];
				$_FILES[$this->key]['error'] = $files['error'][$i];
				$_FILES[$this->key]['size'] = $files['size'][$i];

				//TODO: Verificar nesta etapa se todos os arquivos enviados estao sendo validados pela função do_upload.
				if (!$this->save_files()) {
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
	/**
	* Save the files on folder 
	* push a new key with the encrypted file's name to array
	*
	* @return bool
	*/
	public function save_files()
	{
		$this->upload->initialize($this->configuration);
		
		if (!$this->upload->do_upload($this->key)) {
			return FALSE;
		}
		
		// Save file's name in array to store in database
		array_push($this->fileNames, $this->upload->data('file_name')); 
		return TRUE;
	}
}