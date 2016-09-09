<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once (dirname(__FILE__) . '/MY_Upload.php');


class ContentController extends CI_Controller
{
    public $alert = [
            'success' => 'Upload complete.',
            'error' => 'Upload error',
        ];
        
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['upload', 'session']);
        $this->load->helper(['form', 'url']);
        $this->load->model('upload_model_example');
    }
    
    public function do_upload()
    {
        $upload = new MY_Upload('userFile', 'uploads/files/');
        
        if (!$upload->initialize()) {
            $this->session->set_flashdata('statusMessage', $this->alert['error']);
            log_message('error', $upload->messageError);
            redirect();
        }
        
        if (!$this->upload_model_example->save($upload->fileNames)) {
            $this->session->set_flashdata('statusMessage', $this->alert['error']);
            redirect();
        }
        
        $this->set_flashdata('statusMessage', $ths->alert['success']);
        $this->load->view('your_view');
    }
}