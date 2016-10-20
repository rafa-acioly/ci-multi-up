<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Upload
{
    /**
     * Storage the encrypt name of files.
     *
     * @var array
     */
    public $fileNames = [];

    /**
     * Use the key used in global variable $_FILES
     *
     * @var string
     */
    public $key;
    
    /*
     * Instance of core for libraries
     * 
     */
    protected $ci;
    
    /**
     * Store the error message if has any
     *
     * @var string
     */
    public $messageError;

    /**
     * Set the configuration for uploaded files.
     *
     * @var array
     */
    public $configuration = [
            'upload_path' => '',
            'allowed_types' => 'gif|jpg|png',
            'encrypt_name' => true,
        ];

    /**
     * Define the key on $_FILES that will be used for upload
     * and the folder to store the files
     * 
     * @param string $key
     * @param string $upload_path
     */
    public function __construct($key, $upload_path)
    {
        $this->key = $key;
        $this->configuration['upload_path'] = $upload_path;
        $this->ci =& get_instance();
    }
    
    /**
     * Perform loop to upload files if any key is defined.
     * 
     */
    public function initialize()
    {
        if (!$this->hasFile()) {
            throw new Exception("The key {$this->key} does not exist", 1);
        }
        
        if (!$this->validateFiles()) {
            throw new Exception($this->messageError, 1);
        }

        return true;
    }

    /**
     * Check if there is a key defined on $_FILES.
     *
     *
     * @return bool
     */
    public function hasFile()
    {
        return isset($_FILES[$this->key]);
    }

    /**
     * Save the files on folder
     * push a new key with the encrypted file's name to array.
     *
     * @return bool
     */
    public function saveFiles()
    {
        $this->ci->upload->initialize($this->configuration);

        if (!$this->ci->upload->do_upload($this->key)) {
            return false;
        }

        // Save file's name in array
        array_push($this->fileNames, $this->ci->upload->data('file_name'));

        return true;
    }

    /**
     * Validate files given on the key.
     *
     * @param string $key
     *
     * @return bool
     */
    public function validateFiles()
    {
        $filesCount = count($_FILES[$this->key]['name']);
        $files = $_FILES[$this->key];

        for ($i = 0; $i < $filesCount; ++$i) {
            $_FILES[$this->key]['name'] = $files['name'][$i];
            $_FILES[$this->key]['type'] = $files['type'][$i];
            $_FILES[$this->key]['tmp_name'] = $files['tmp_name'][$i];
            $_FILES[$this->key]['error'] = $files['error'][$i];
            $_FILES[$this->key]['size'] = $files['size'][$i];
            
            if (!$this->saveFiles($this->key)) {
                $this->messageError = $this->ci->upload->display_errors();
                return false;
            }
        }
        return true;
    }
}
