<?php




class UserModel extends CI_Model
{
    /**
     * Called during initialization. Appends
     * our custom field to the module's model.
     */
    protected function initialize()
    {
        $this->allowedFields[] = 'middlename';
    }

    function insertData($data){
        $res = $this->db->insert('users',$data);
        if ($res) {
            return true;
        }else{
            return false;
        }
    }
}