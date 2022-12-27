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

    function activateAccount($token){
        $status = 1;
        $data = array('status' => $status);
        $this->db->where('verification_code', $token);
        $res = $this->db->update('users', $data);
        if ($res) {
            return true;
        }else{
            return false;
        }
    }

    function checkSignin($data){
        $query = $this->db->get_where('users', $data);
        $res =  $query->row();
        if ($res) {
            return $res;
        }else{
            return false;
        }
    }

    function updLexDetail($data,$id){
        $this->db->where('id',$id);
        $res = $this->db->update('users', $data);
        if ($res) {
            return true;
        }else{
            return false;
        }
    }
}