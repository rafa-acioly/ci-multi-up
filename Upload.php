<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller
{
	/**
	 * 
	 * Storage the encrypt name of files 
	 * @type array
	 */
	public $fileNames = [];
	
	
	/**
	 * 
	 * Define the messages for sessions
	 * @type array
	 */
	public $alert = [
			'success' => 'All file uploaded successfully',
			'error' => 'Sorry something gone wrong with upload, please contact the admin',
			'fatal' => 'Could not upload the files',
		];
	
	
	/**
	 * 
	 * Set the configuration for uploaded files
	 * @type array
	 */ 
	public $configuration = [
			'upload_path' => 'uploads/file/',
			'allowed_types' => 'gif|jpg|png',
			'encrypt_name' => TRUE
		];
	
	
	/**
	 * 
	 * Load the main modules to use form and url on the view
	 * 
	 */ 
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
		if (!$this->validateFiles('userFile')) {
			throw new Exception($this->alert['fatal'].' '.$this->upload->display_errors(), 1);
		}
		
		/**
		 * Set your model and function to save the file's name in database
		 */
		if (!$this->YOUR_MODEL->YOUR_FUNCTION($this->fileNames)) {
			$this->session->set_flashdata('statusMsg', $this->alert["error"]);
			$this->load->view('index');
		}
		
		$this->session->set_flashdata('statusMsg', $this->alert["success"]);
		$this->load->view('index');
	}
	
	
	/**
	 * 
	 * Validate files given on the key
	 * @param string $key
	 * @return bool
	 */ 
	public function validateFiles($key)
	{
		if ($this->hasFile($key)) {
			
			$filesCount = count($_FILES[$key]['name']);
			$files = $_FILES[$key];
			
			for($i = 0; $i < $filesCount; $i++){
				$_FILES[$key]['name'] = $files['name'][$i];
				$_FILES[$key]['type'] = $files['type'][$i];
				$_FILES[$key]['tmp_name'] = $files['tmp_name'][$i];
				$_FILES[$key]['error'] = $files['error'][$i];
				$_FILES[$key]['size'] = $files['size'][$i];

				//TODO: Verificar nesta etapa se todos os arquivos enviados estao sendo validados pela função do_upload.
				if (!$this->saveFiles($key)) {
					// salva um registro no arquivo de log com o erro.
					log_message($this->upload->display_errors().": ".date('d/m/Y H:m:s'));
					return FALSE;
				}
			}
		}
		return TRUE;
	}
	
	/**
	 * 
	 * Check if there is a key defined on $_FILES
	 * @param string $key
	 * @return bool
	 */ 
	public function hasFile($key)
	{
		return isset($_FILES[$key]);
	}
	
	
	/**
	* Save the files on folder 
	* push a new key with the encrypted file's name to array
	*
	* @return bool
	*/
	public function saveFiles()
	{
		$this->upload->initialize($this->configuration);
		
		if (!$this->upload->do_upload($key)) {
			return FALSE;
		}
		
		// Save file's name in array
		array_push($this->fileNames, $this->upload->data('file_name')); 
		return TRUE;
	}
}