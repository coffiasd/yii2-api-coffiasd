<?php
namespace app\web\common;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\data\ActiceDataProvider;
use yii\helpers\ArrayHelper ;

class ApiController extends Controller{
	public $modelClass;
	public $params;
	private $data;
	private $code;
	
	public function init(){
		//set response format
		Yii::$app->response->format='json';

		if($this->modelClass !== null)
			$this->modelClass = new $this->modelClass;

	}

	public function actions(){
		return [
			'getlist'=> [
					'class'=>'app\web\common\CommonRunController',
				   	'modelClass'=>$this->modelClass,
		     ],
			 'created'=> [
					'class'=>'app\web\common\CommonRunController',
				   	'modelClass'=>$this->modelClass,
		     ],
			 'delete'=> [
					'class'=>'app\web\common\CommonRunController',
				   	'modelClass'=>$this->modelClass,
		     ],
			 'modify'=> [
					'class'=>'app\web\common\CommonRunController',
				   	'modelClass'=>$this->modelClass,
		     ],
	    ];
	}
	
	//返回json数组
	public function afterAction($action,$result){
	    //request cid
	    $cid = Yii::$app->controller->action->id;
	    
	    if(method_exists($this, 'Resp'.$cid)){
	        $cid = 'Resp'.$cid;
	        $result = $this->$cid($result);
	    }
	    
	    //response json
		Yii::$app->response->data =	$result; 
		Yii::$app->response->send();
	}
	
	//验证
	public function beforeAction($action){
		//jump sign
	    if(Yii::$app->request->get('jump') ||  Yii::$app->request->post('jump'))
			return true;
		
		$params = array_merge(Yii::$app->request->get(),Yii::$app->request->post());	
		if(!isset($params['sign']))
			return $this->afterAction($action,['data'=>[],'status'=>203,'msg'=>'sign lose']);	

		$signbefore = $params;
		unset($params['sign']);
		$signafter = $params; 
		ksort($params);
		$str='';
		foreach($params as $v){
			$str.=$v;	
		}

		//连接自定义字符串
		$str.=Yii::$app->params['sign'];
		$sign = md5($str);	
		
		if($sign != $signbefore['sign'])
			return $this->afterAction($action,['data'=>[],'status'=>203,'msg'=>'sign lose']);	

		return true; 
	}

}
?>
