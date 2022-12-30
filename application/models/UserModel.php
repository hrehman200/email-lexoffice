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

    function insertData($data)
    {
        $res = $this->db->insert('users', $data);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function activateAccount($token)
    {
        $status = 1;
        $data = array('status' => $status);
        $this->db->where('verification_code', $token);
        $res = $this->db->update('users', $data);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function checkSignin($data)
    {
        $query = $this->db->get_where('users', $data);
        $res =  $query->row();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    function updLexDetail($data, $id)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('users', $data);
        if ($res) {
            return $this->get($id);
        } else {
            return false;
        }
    }

    function get($id)
    {
        $user = $this->db->get_where('users', ['id' => $id])->result_array()[0];
        return $user;
    }

    function getAll()
    {
        $users = $this->db->get_where('users', ['lex_api_key != ' => null])->result_array();
        return $users;
    }

    function getByLexEmail($lex_email)
    {
        $user = $this->db->get_where('users', ['lex_email' => $lex_email])->result_array()[0];
        return $user;
    }

    function makeRequest($end_point, $api_key = LEXOFFICE_API_TOKEN, $params = [], $post = false)
    {
        $curl = curl_init();

        $fp = fopen(FCPATH . 'application/logs/errorlog.txt', 'w');

        $config_arr = [
            CURLOPT_URL => LEX_API_BASE_URL . $end_point,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_VERBOSE => 1,
            CURLOPT_STDERR => $fp,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $api_key,
                'Accept: application/json'
            ),
            //CURLOPT_AUTOREFERER => TRUE,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ];

        if($end_point == 'files' && count($params) > 0) {
            $config_arr[CURLOPT_POSTFIELDS] = $params;
        } else if (count($params) > 0) {
            $config_arr[CURLOPT_POSTFIELDS] = json_encode($params);
            $config_arr[CURLOPT_HTTPHEADER][] = 'Content-Type: application/json';
        }

        if ($post) {
            //$config_arr[CURLOPT_POST] = 1;
            $config_arr[CURLOPT_CUSTOMREQUEST] = 'POST';
        } else {
            $config_arr[CURLOPT_CUSTOMREQUEST] = 'GET';
        }

        curl_setopt_array($curl, $config_arr);

        $response = curl_exec($curl);
        log_message('error', $response);

        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        log_message('error', $httpcode);

        curl_close($curl);
        
        $response = json_decode($response, true);
        return $response;
    }

    function checkLexApiKey($api_key)
    {
        $response = $this->makeRequest('profile', $api_key);
        if (array_key_exists('organizationId', $response)) {
            return true;
        }
        return false;
    }

    function createCustomerOnLex($id)
    {
        $user = $this->get($id);

        $parts = explode(' ', $user['name']);
        $first_name = $parts[0];
        array_shift($parts);
        $last_name = join(' ', $parts);
        if($last_name == '') {
            $last_name = 'last';    // its kind of required :)
        }

        $payload = [
            //"version" => 0,
            "roles" => [
                "customer" => new stdClass()
            ],
            // "person" => [
            //     "firstName" => $first_name,
            //     "lastName" => $last_name,
            // ],
            "company" => [
                "name" => $user['company'],
                "contactPersons" => [
                    [
                        //"salutation"=> "Herr",
                        "firstName" => $first_name,
                        "lastName" => $last_name,
                        "primary" => true,
                        "emailAddress" => $user['email'],
                    ]
                ]
            ],
            "addresses" => [
                "billing" => [
                    [
                        "street" => $user['address'],
                        "zip" => $user['zip'],
                        "city" => $user['city'],
                        // "countryCode"=> "DE"
                    ]
                ]
            ]
        ];

        $response = $this->makeRequest('contacts', LEXOFFICE_API_TOKEN, $payload, true);

        if(array_key_exists('id', $response)) {
            return true;
        } else {
            return false;
        }
    }
}
