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
	public $setBody = [] ;
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

        if($this->setMethod === 'post')
        {
            return $this->post();
        }

        if($this->setMethod === 'post')
        {
            return $this->put();
        }

        if($this->setMethod === 'delete')
        {
            return $this->delete();
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

    private function post()
    {
        $curl = $this->curl;
        $data_package = '';
        if($this->setUrl !== "" && is_array($this->setBody))
        {
            $data_package = $this->curl->simple_post(''.$this->setUrl.'', $this->setBody);
        }

        return $data_package;
    }

    private function put()
    {
        $curl = $this->curl;
        $data_package = '';
        if($this->setUrl !== "" && is_array($this->setBody))
        {
            $data_package = $this->curl->simple_put(''.$this->setUrl.'', $this->setBody);
        }

        return $data_package;
    }

    private function delete()
    {
        $curl = $this->curl;
        $data_package = '';
        if($this->setUrl !== "" && is_array($this->setBody))
        {
            $data_package = $this->curl->simple_delete(''.$this->setUrl.'', $this->setBody);
        }

        return $data_package;
    }

    private function myhttp_login($_user="", $_password="")
    {
    	$this->curl->http_login($_user, $_password);
    }


}
