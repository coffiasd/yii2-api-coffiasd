<?php
namespace app\web\modules\api\controllers;

use Yii;
use app\web\common\ApiController; 
use yii\base\Module; 

class UserController extends ApiController
{
	public $defaultAction='getlist';
	public $modelClass = 'app\models\User';

	
	/**
	 * 修改用户头像
	 * @return multitype:number multitype: |multitype:number multitype:Ambigous <multitype:, \yii\web\mixed>
	 */
	public function actionModifyuserpic(){
		if($_FILES){
			$file = new Fileupload($_FILES);		
			$filelist = $file->saveFile();
		}else{
			return ['status'=>201,'data'=>[]];
		}
		
		//获得用户id
		$model = $this->modelClass->findOne(Yii::$app->request->post('id'));
	
		if(empty($model)) 
			return ['status'=>201,'data'=>[]]; 

		if( $model->load($filelist,'') && $model->save())
			return	['status'=>200,'data'=>['id'=>Yii::$app->request->post('id')]]; 
		else
			return ['status'=>201,'data'=>[]];	
	}
	
	/**
	 * 修改用户密码
	 */
	public function actionModifyuserpwd(){
	    //获得用户id
	    $model = $this->modelClass->findOne(Yii::$app->request->get('id'));
	    $pwdbefore = Yii::$app->request->get('pwdbefore');
	    $pwdnow = Yii::$app->request->get('pwdnow');
	    
	    //用户不存在
	    if(empty($model)||empty($pwdbefore)||empty($pwdnow))
	        return ['status'=>202,'data'=>[]];
	    
	    $userinfo = $model->attributes;
        $pwd = $userinfo['pwd'];
        
        //判断密码
        if($pwdbefore!==$pwd || empty($pwd))
            return ['status'=>205,'data'=>[]];
        
        $post = ['pwd'=>$pwdnow];
        if($model->load($post,'') && $model->save())
            return ['status'=>200,'data'=>['id'=>Yii::$app->request->get('id')]];
        return ['status'=>201,'data'=>[]];
	}
}
