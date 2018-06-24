<?php
class Curl {
    
    const USER_AGENT = 'Xgold';

    function __construct() {
        if (!extension_loaded('curl')) {
            throw new ErrorException('cURL library is not loaded');
        }

        $this->init();
    }
    
    function init()
    {
        $this->curl = curl_init();
        $this->setUserAgent(self::USER_AGENT);
        $this->setopt(CURLINFO_HEADER_OUT, TRUE);
        $this->setopt(CURLOPT_HEADER, TRUE);
        $this->setopt(CURLOPT_RETURNTRANSFER, TRUE);
    }

    function get($url, $headers=array()) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $info = json_decode($response);
        
        return $info;
    }

    function checkTransaction($hash, $token) {
        $headers = ['access-token: '.$token];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL.'/v2/get_transaction_detail/'.$hash);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $info = json_decode($response);
        
        return $info;
    }

    function createAddress($token) { 
        $headers = ['access-token: '.$token];
        $nodes = [
            API_URL.'/v2/create/btc',
            API_URL.'/v2/create/eth',
            API_URL.'/v2/create/ltc',
            API_URL.'/v2/create/bch'
        ];
        $node_count = count($nodes);
        $curl_arr = array();
        $master = curl_multi_init();
        for($i = 0; $i < $node_count; $i++)
        {
            $url =$nodes[$i];
            $curl_arr[$i] = curl_init($url);
            curl_setopt($curl_arr[$i], CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($master, $curl_arr[$i]);
        }
        do {
            curl_multi_exec($master,$running);
        } while($running > 0);
        for($i = 0; $i < $node_count; $i++)
        {
            $results[] = curl_multi_getcontent  ( $curl_arr[$i]  );
        }

        $results[] = '{"code": 200, "currency": "token", "address": ""}';
        $response = [];
        foreach ($results as $result) {
            $response[] = json_decode($result);
        }

        return $response;
    }

    function getV2($url, $data=array()) {
        $this->setopt(CURLOPT_URL, $url . '?' . http_build_query($data));
        $this->setopt(CURLOPT_HTTPGET, TRUE);
        
        return json_decode(curl_exec($this->curl));
    }

    function post($url, $data=array()) {       
        $this->setopt(CURLOPT_URL, $url);
        $this->setopt(CURLOPT_POST, TRUE);
        $this->setopt(CURLOPT_POSTFIELDS, $this->_postfields($data));
        $this->_exec();
    }

    function postUrl($url, $data=array()) {
        $this->setopt(CURLOPT_URL, $url);
        $this->setopt(CURLOPT_VERBOSE, true);
        $this->setopt(CURLOPT_POST, true);
        $this->setopt(CURLOPT_FOLLOWLOCATION, true);
        $this->setopt(CURLOPT_POSTFIELDS, $data);
        $this->_exec();
    }

    function getToken() { 
        $headers = ['api-key: '.API_KEY, 'secret: '.API_SECRET, 'Content-Type: application/x-www-form-urlencoded']; 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
        curl_setopt($ch, CURLOPT_URL, API_URL.'/v2/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, []);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        
        return json_decode($response)->access_token;
    }

    function send($token, $data) { 
        $headers = ['access-token: '.$token];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
        curl_setopt($ch, CURLOPT_URL, API_URL.'/v2/send');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        
        return json_decode($response);
    }

    function postV2($url, $data=array()){
        $postvars = '';
        foreach($data as $key=>$value) {
            $postvars .= $key . "=" . $value . "&";
        }
        $postvars = rtrim($postvars, '&');
        $this->setopt(CURLOPT_URL, $url);
        $this->setopt(CURLOPT_POST, TRUE);
        $this->setopt(CURLOPT_POSTFIELDS, $postvars);
        $this->_exec();
    }

    function put($url, $data=array()) {
        $this->setopt(CURLOPT_URL, $url . '?' . http_build_query($data));
        $this->setopt(CURLOPT_CUSTOMREQUEST, 'PUT');
        $this->_exec();
    }

    function patch($url, $data=array()) {
        $this->setopt(CURLOPT_URL, $url);
        $this->setopt(CURLOPT_CUSTOMREQUEST, 'PATCH');
        $this->setopt(CURLOPT_POSTFIELDS, $data);
        $this->_exec();
    }

    function delete($url, $data=array()) {
        $this->setopt(CURLOPT_URL, $url . '?' . http_build_query($data));
        $this->setopt(CURLOPT_CUSTOMREQUEST, 'DELETE');
        $this->_exec();
    }

    function setBasicAuthentication($username, $password) {
        $this->setopt(CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $this->setopt(CURLOPT_USERPWD, $username . ':' . $password);
    }

    function setHeader($key, $value) {
        $this->_headers[$key] = $key . ': ' . $value;
        $this->setopt(CURLOPT_HTTPHEADER, array_values($this->_headers));
    }

    function setUserAgent($user_agent) {
        $this->setopt(CURLOPT_USERAGENT, $user_agent);
    }

    function setReferrer($referrer) {
        $this->setopt(CURLOPT_REFERER, $referrer);
    }

    function setCookie($key, $value) {
        $this->_cookies[$key] = $value;
        $this->setopt(CURLOPT_COOKIE, http_build_query($this->_cookies, '', '; '));
    }

    function setOpt($option, $value) {
        return curl_setopt($this->curl, $option, $value);
    }

    function verbose($on=TRUE) {
        $this->setopt(CURLOPT_VERBOSE, $on);
    }

    function close() {
        curl_close($this->curl);
    }

    function http_build_multi_query($data, $key=NULL) {
        $query = array();

        foreach ($data as $k => $value) {
            if (is_string($value)) {
                $query[] = urlencode(is_null($key) ? $k : $key) . '=' . rawurlencode($value);
            }
            else if (is_array($value)) {
                $query[] = $this->http_build_multi_query($value, $k . '[]');
            }
        }

        return implode('&', $query);
    }

    function _postfields($data) {
        if (is_array($data)) {
            if ($this->is_array_multidim($data)) {
                $data = $this->http_build_multi_query($data);

            }
            else {
                // Fix "Notice: Array to string conversion" when $value in
                // curl_setopt($ch, CURLOPT_POSTFIELDS, $value) is an array
                // that contains an empty array.
                foreach ($data as &$value) {
                    if (is_array($value) && empty($value)) {
                        $value = '';
                    }
                }
            }
        }

        return $data;
    }

    function _exec() {
        $this->response = curl_exec($this->curl);
        $this->curl_error_code = curl_errno($this->curl);
        $this->curl_error_message = curl_error($this->curl);
        $this->curl_error = !($this->curl_error_code === 0);
        $this->http_status_code = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        $this->http_error = in_array(floor($this->http_status_code / 100), array(4, 5));
        $this->error = $this->curl_error || $this->http_error;
        $this->error_code = $this->error ? ($this->curl_error ? $this->curl_error_code : $this->http_status_code) : 0;
        $this->request_headers = preg_split('/\r\n/', curl_getinfo($this->curl, CURLINFO_HEADER_OUT), NULL, PREG_SPLIT_NO_EMPTY);
        $this->response_headers = '';
        if (!(strpos($this->response, "\r\n\r\n") === FALSE)) {
            list($response_header, $this->response) = explode("\r\n\r\n", $this->response, 2);
            if ($response_header === 'HTTP/1.1 100 Continue') {
                list($response_header, $this->response) = explode("\r\n\r\n", $this->response, 2);
            }
            $this->response_headers = preg_split('/\r\n/', $response_header, NULL, PREG_SPLIT_NO_EMPTY);
        }

        $this->http_error_message = $this->error ? (isset($this->response_headers['0']) ? $this->response_headers['0'] : '') : '';
        $this->error_message = $this->curl_error ? $this->curl_error_message : $this->http_error_message;

        return $this->error_code;
    }
    
    function reset()
    {
        $this->close();
        $this->init();
    }

    function __destruct() {
        $this->close();
    }

    function is_array_multidim($array) {
        if (!is_array($array)) {
            return FALSE;
        }

        return !(count($array) === count($array, COUNT_RECURSIVE));
    }

    private $_cookies = array();
    private $_headers = array();

    public $curl;

    public $error = FALSE;
    public $error_code = 0;
    public $error_message = NULL;

    public $curl_error = FALSE;
    public $curl_error_code = 0;
    public $curl_error_message = NULL;

    public $http_error = FALSE;
    public $http_status_code = 0;
    public $http_error_message = NULL;

    public $request_headers = NULL;
    public $response_headers = NULL;
    public $response = NULL;
}


