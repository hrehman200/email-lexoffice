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

    function makeRequest($end_point, $api_key = LEXOFFICE_API_TOKEN, $params = [], $post = false) 
    {
        $curl = curl_init();

        $config_arr = [
            CURLOPT_URL => LEX_API_BASE_URL . $end_point,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $api_key,
                'Accept: application/json'
            ),
        ];

        if(count($params) > 0) {
            $config_arr['CURLOPT_POSTFIELDS'] = $params;
        }

        if ($post) {
            $config_arr['CURLOPT_CUSTOMREQUEST'] = 'POST';
        }

        curl_setopt_array($curl, $config_arr);

        $response = curl_exec($curl);
        curl_close($curl);
        //echo $response;

        $response = json_decode($response, true);
        return $response;
    }

    function checkLexApiKey($api_key) {
        $response = $this->makeRequest('profile', $api_key);
        if(array_key_exists('userEmail', $response)) {
            return true;
        }
        return false;
    }
}