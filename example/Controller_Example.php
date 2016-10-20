<?php
defined('BASEPATH') or exit('No direct script access allowed');

# Include the file
require_once (dirname(__FILE__) . '/MY_Upload.php');


class Controller_Example extends CI_Controller
{
    # Optional
    # Set the alert messages
    public $alert = [
            'success' => 'Upload complete.',
            'error' => 'Upload error',
        ];
        
    public function __construct()
    {
        # IMPORTANT
        # include all the library's and helper's
        parent::__construct();
        $this->load->library(['upload', 'session']);
        $this->load->helper(['form', 'url']);
        $this->load->model('upload_model_example');
    }
    
    public function do_upload()
    {
        $upload = new MY_Upload('userFile', 'uploads/files/');
        
        # If the upload don't go well....
        if (!$upload->initialize()) {
            $this->session->set_flashdata('statusMessage', $this->alert['error']);
            log_message('error', $upload->messageError);
            redirect(); # Redirect to the same page (refresh page)
        }
        
        # Cannot save the file names in database?
        if (!$this->upload_model_example->save($upload->fileNames)) {
            $this->session->set_flashdata('statusMessage', $this->alert['error']);
            redirect(); # Redirect to the same page (refresh page)
        }
        
        $this->set_flashdata('statusMessage', $ths->alert['success']);
        $this->load->view('your_view');
    }
}