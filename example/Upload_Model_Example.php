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
        # Making a loop through file names to insert into database
        foreach ($fileNames as $value) {
            # If something wrong...
            if (!$this->db->insert('my_table', $value)) {
                return false;
            }
        }
        
        return true;
    }
}