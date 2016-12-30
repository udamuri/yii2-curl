<?php
namespace udamuri\curl;

/**
 * YII2 CURL using Library codeigniter by http://philsturgeon.co.uk/code/codeigniter-curl
 * @author  Muri Budiman
 * @link    http://muribudiman.wordpress.com
 */

class Curl extends \yii\base\Widget
{

	protected $response = '';           
	protected $session;             
    protected $url;                 
    protected $options = array();   
    protected $headers = array();   
    public $error_code;             
    public $error_string;           
    public $info;    
    public                


    public function run()
    {

        if (!$this->is_enabled()) {
            return 'cURL Class - PHP was not built with cURL enabled. Rebuild PHP with --with-curl to use cURL.';
        }

        //$url AND $this->create($url);
    }

 
 
    public function __call($method, $arguments) {
        if (in_array($method, array('simple_get', 'simple_post', 'simple_put', 'simple_delete'))) {
            // ambil data kemudian di memanggil fungsi dari _simple_call
            $verb = str_replace('simple_', '', $method);
            array_unshift($arguments, $verb);
            return call_user_func_array(array($this, '_simple_call'), $arguments);
        }
    }

    public function _simple_call($method, $url, $params = array(), $options = array()) {
        // Get acts differently, as it doesnt accept parameters in the same way
        if ($method === 'get') {
            //hanya get saja
            $this->create($url . ($params ? '?' . http_build_query($params, NULL, '&') : ''));
        } else {
            // buat sessi baru
            $this->create($url);

            $this->{$method}($params);
        }

        // tambah ke option
        $this->options($options);
        //eksekusi
        return $this->execute();
    }

    public function post($params = array(), $options = array()) {
        //http_build_query jika bukan array
        if (is_array($params)) {
            $params = http_build_query($params);
        }

        // tambahin option jika ada
        $this->options($options);

        $this->http_method('post');

        $this->option(CURLOPT_POST, 1);
        $this->option(CURLOPT_POSTFIELDS, $params);
    }

    public function put($params = array(), $options = array()) {
        //http_build_query jika bukan array
        if (is_array($params)) {
            $params = http_build_query($params, NULL, '&');
        }

        // tambahin option jika ada
        $this->options($options);

        $this->http_method('put');
        $this->option(CURLOPT_POSTFIELDS, $params);

        // Mengganti data header POST menjadi PUT
        $this->option(CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override: PUT'));
    }

    public function delete($params, $options = array()) {
        //http_build_query jika bukan array
        if (is_array($params)) {
            $params = http_build_query($params, NULL, '&');
        }

        // tambahin option jika ada
        $this->options($options);

        $this->http_method('delete');

        $this->option(CURLOPT_POSTFIELDS, $params);
    }

    public function set_cookies($params = array()) {
        if (is_array($params)) {
            $params = http_build_query($params, NULL, '&');
        }

        $this->option(CURLOPT_COOKIE, $params);
        return $this;
    }

    public function http_header($header, $content = NULL) {
        $this->headers[] = $content ? $header . ': ' . $content : $header;
    }

    /**
     * Untuk Menset custom Method selain post put delete dan get
     * @param String $method Nama Method yang di inginkan
     */
    public function http_method($method) {
        $this->options[CURLOPT_CUSTOMREQUEST] = strtoupper($method);
        return $this;
    }

    public function http_login($username = '', $password = '', $type = 'any') {
        $this->option(CURLOPT_HTTPAUTH, constant('CURLAUTH_' . strtoupper($type)));
        $this->option(CURLOPT_USERPWD, $username . ':' . $password);
        return $this;
    }

    public function proxy($url = '', $port = 80) {
        $this->option(CURLOPT_HTTPPROXYTUNNEL, TRUE);
        $this->option(CURLOPT_PROXY, $url . ':' . $port);
        return $this;
    }

    public function proxy_login($username = '', $password = '') {
        $this->option(CURLOPT_PROXYUSERPWD, $username . ':' . $password);
        return $this;
    }

    public function ssl($verify_peer = TRUE, $verify_host = 2, $path_to_cert = NULL) {
        if ($verify_peer) {
            $this->option(CURLOPT_SSL_VERIFYPEER, TRUE);
            $this->option(CURLOPT_SSL_VERIFYHOST, $verify_host);
            $this->option(CURLOPT_CAINFO, $path_to_cert);
        } else {
            $this->option(CURLOPT_SSL_VERIFYPEER, FALSE);
        }
        return $this;
    }

    public function options($options = array()) {
        // Merge options in with the rest - done as array_merge() does not overwrite numeric keys
        foreach ($options as $option_code => $option_value) {
            $this->option($option_code, $option_value);
        }

        // Set all options provided
        curl_setopt_array($this->session, $this->options);

        return $this;
    }
  
    public function option($code, $value) {
        if (is_string($code) && !is_numeric($code)) {
            $code = constant('CURLOPT_' . strtoupper($code));
        }

        $this->options[$code] = $value;
        return $this;
    }

    public function create($url) {
        $this->url = $url;
        $this->session = curl_init($this->url);

        return $this;
    }

    public function execute() {
        if (!isset($this->options[CURLOPT_TIMEOUT])) {
            $this->options[CURLOPT_TIMEOUT] = 30;
        }
        if (!isset($this->options[CURLOPT_RETURNTRANSFER])) {
            $this->options[CURLOPT_RETURNTRANSFER] = TRUE;
        }
        if (!isset($this->options[CURLOPT_FAILONERROR])) {
            $this->options[CURLOPT_FAILONERROR] = TRUE;
        }

        if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
            // Ok, follow location is not set already so lets set it to true
            if (!isset($this->options[CURLOPT_FOLLOWLOCATION])) {
                $this->options[CURLOPT_FOLLOWLOCATION] = TRUE;
            }
        }

        if (!empty($this->headers)) {
            $this->option(CURLOPT_HTTPHEADER, $this->headers);
        }

        $this->options();

        $this->response = curl_exec($this->session);
        $this->info = curl_getinfo($this->session);

        if ($this->response === FALSE) {
            $errno = curl_errno($this->session);
            $error = curl_error($this->session);

            curl_close($this->session);
            $this->set_defaults();

            $this->error_code = $errno;
            $this->error_string = $error;

            return FALSE;
        }

        else {
            curl_close($this->session);
            $this->last_response = $this->response;
            $this->set_defaults();
            return $this->last_response;
        }
    }

    public function is_enabled() {
        return function_exists('curl_init');
    }

    public function debug() {
        echo "=============================================<br/>\n";
        echo "<h2>CURL Test</h2>\n";
        echo "=============================================<br/>\n";
        echo "<h3>Response</h3>\n";
        echo "<code>" . nl2br(htmlentities($this->last_response)) . "</code><br/>\n\n";

        if ($this->error_string) {
            echo "=============================================<br/>\n";
            echo "<h3>Errors</h3>";
            echo "<strong>Code:</strong> " . $this->error_code . "<br/>\n";
            echo "<strong>Message:</strong> " . $this->error_string . "<br/>\n";
        }

        echo "=============================================<br/>\n";
        echo "<h3>Info</h3>";
        echo "<pre>";
        print_r($this->info);
        echo "</pre>";
    }

    public function debug_request() {
        return array(
            'url' => $this->url
        );
    }

    public function set_defaults() {
        $this->response = '';
        $this->headers = array();
        $this->options = array();
        $this->error_code = NULL;
        $this->error_string = '';
        $this->session = NULL;
    }
}
