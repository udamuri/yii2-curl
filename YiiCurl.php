<?php
namespace udamuri\curl;

/**
 * YII2 CURL using Library codeigniter by http://philsturgeon.co.uk/code/codeigniter-curl
 * @author  Muri Budiman
 * @link    http://muribudiman.wordpress.com
 */

class YiiCurl extends \yii\base\Widget
{

    public function run()
    {
    	require_once( dirname(__FILE__) . '/curl.php');
		return 'tes';
    }


}
