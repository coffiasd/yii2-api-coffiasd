<?php
namespace app\web\modules\api\controllers;

use Yii;
use app\web\common\ApiController; 
use yii\base\Module; 

class DynamicController extends ApiController
{
	public $defaultAction='getlist';
	public $modelClass = 'app\models\Dynamic';
    
	/**
	 * 点赞
	 */
	public function actionAddpraise(){
	    //用户id
	    $uid = Yii::$app->request->get('uid');
	    //动态id
	    $did = Yii::$app->request->get('did');
	    if(empty($uid)||empty($did))
	        return ['status'=>202,'data'=>[]];
	    
	    $model = $this->modelClass->findOne($did);
	    $pinfo = $model->attributes;
	    $praise = $pinfo['praise'];
	    //获得新的info
	    $info = empty($praise)?$did:$praise."#".$did;
	    //保存
	    if($model->load(['praise'=>$info],'') && $model->save())
            return ['status'=>200,'data'=>[$did]];
	    //保存失败
	    return ['status'=>201,'data'=>[]];
	}
}
