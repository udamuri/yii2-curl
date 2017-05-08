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

	public $setMethod = "get" ;
	public $setAuth = [] ;
	public $setUrl = "" ;

    public function __construct( /*...*/ ) {
        require_once( dirname(__FILE__) . '/curl.php');
        $this->curl = new curl();
    }

    public function run()
    {
    	if( is_array($this->setAuth) )
    	{
    		if(count($this->setAuth) == 2)
    		{
    			$this->myhttp_login($this->setAuth[0], $this->setAuth[1]);
    		}
    	}

    	if($this->setMethod === 'get')
    	{
    		return $this->simple_get();
    	}

		return null;
    }

    private function simple_get()
    {
    	$curl = $this->curl;
    	$data_package = '';
    	if($this->setUrl !== "")
    	{
	    	$data_package = $this->curl->simple_get(''.$this->setUrl.'');
    	}
    	
		return $data_package;
    }

    private function myhttp_login($_user="", $_password="")
    {
    	$this->curl->http_login($_user, $_password);
    }


}
