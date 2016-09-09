<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Upload_Model_Example extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    
    public function save($fileNames)
    {
        foreach ($fileNames as $value) {
            if (!$this->db->insert('my_table', $value)) {
                return false;
            }
        }
        
        return true;
    }
}