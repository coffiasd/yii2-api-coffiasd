<?php
namespace app\web\modules\api\controllers;

use Yii;
use app\web\common\ApiController; 
use yii\base\Module; 

class MsgController extends ApiController
{
    public function actionSend(){
        $mobile = Yii::$app->request->get('mobile');
        $code = $this->getcode();
        $this->toPsersionMobile($code,$mobile);
        return ['status'=>200,'data'=>[$code]];
    }
    
    /**
     * 获得code
     * @param number $length
     * @return string
     */
    private function getcode($length=4){
		$chars = '0123456789';	
		$str='';
		for($i=0;$i<$length;$i++){
			$str.= $chars[ mt_rand(0, strlen($chars) - 1) ];  	
		}
		return $str;
    }
    
    /**
     * 发送到手机
     * @param number $code
     * @param number $mobile
     */
    private function toPsersionMobile($code=1234,$mobile=13968114566){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://sms-api.luosimao.com/v1/send.json");
        
        curl_setopt($ch, CURLOPT_HTTP_VERSION  , CURL_HTTP_VERSION_1_0 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        
        curl_setopt($ch, CURLOPT_HTTPAUTH , CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD  , 'api:key-a05dd152d76b42790eea6d315a5cd44b');
        
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('mobile' => $mobile,'message' => '验证码：'.$code.'【微体】'));
        
        $res = curl_exec( $ch );
        curl_close( $ch );
    }
}
