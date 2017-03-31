<?php
namespace udamuri\curl;

/**
 * YII2 CURL using Library codeigniter by http://philsturgeon.co.uk/code/codeigniter-curl
 * @author  Muri Budiman
 * @link    http://muribudiman.wordpress.com
 */

class YiiCurl extends \yii\base\Widget
{

	protected $curl;

	public $call = "" ;
	public $http_login = "" ;
	public $url = "" ;

    public function __construct( /*...*/ ) {
        require_once( dirname(__FILE__) . '/curl.php');
        $this->curl = new curl();
    }

    public function run()
    {
    	if($this->call === 'simple_get')
    	{
    		return $this->simple_get();
    	}
    	
		return null;
    }

    private function simple_get()
    {
    	$curl = $this->curl;
    	$data_package = '';
    	if($this->url !== "")
    	{
	    	if( is_array($this->http_login) )
	    	{
	    		if(count($this->http_login) == 2)
	    		{
	    			$curl->http_login(''.$this->http_login[0].'', ''.''.$this->http_login[1].''.'');
	    		}
	    	}

	    	$data_package = $curl->simple_get(''.$this->url.'');
    	}

    	$arrData = [
			'data' => $data_package,
			'debug' => $curl->debug()
		];

		return $arrData;
    }


}
