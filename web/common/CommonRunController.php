<?php
namespace app\web\common;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\helpers\ArrayHelper ;
use app\web\common\Fileupload;

class CommonRunController extends \yii\base\Action{
	public $modelClass;
	
	public function run(){
		$cid = Yii::$app->controller->action->id;
		return $this->$cid();
	}

	
	private function getlist(){
		$modelClass = $this->modelClass;
		
		//gets	
		$gets = Yii::$app->request->get();
		
		//attributeLabels
		$attri = $modelClass->attributeLabels();
		
		//default condition	
		$condition = $modelClass::find();

		if(!empty($gets) && is_array($gets)){
			foreach($gets as $k=>$v){
				if(isset($attri[$k]))
					$condition->where([$k=>$v]);	
			}
		}
		
		$pageSize = isset($gets['pagesize'])?$gets['pagesize']:Yii::$app->params['pageSize'];	

		$res = new ActiveDataProvider([
			'query'=>$condition,
			'pagination'=> [
				'pagesize'=>$pageSize,
			],
		]);
		//$data = $res->getmodels();
		return	['status'=>200,'data'=>$res->getmodels()]; 
	}
	
	//getone is deleted
	private function getone(){
		$data = $this->modelClass->findOne(Yii::$app->request->get('id'));	
		if(!empty($data))
			$data = arrayHelper::toArray($data);
		else
			$data=[];
		return ['status'=>200,'data'=>$data];
	}

	private function delete(){
		$data = $this->modelClass->findOne(Yii::$app->request->get('id'));
		if(empty($data))
			return ['status'=>202,'data'=>[]]; 
		
		$data = $data->delete();

		if($data === 1)
			return ['status'=>200,'data'=>['id'=>Yii::$app->request->get('id')]];
		return ['status'=>204,'data'=>[]];
	}

	private function created(){
		$post = Yii::$app->request->post();
		//check file
		if($_FILES){
			$file = new Fileupload($_FILES);		
			$filelist = $file->saveFile();
			$post  = array_merge($post,$filelist);
		}
		
		//set default value	
		if(is_array($this->modelClass->loadDefaultValues()))
		      $post = array_merge($post,$this->modelClass->loadDefaultValues());
		
		$this->modelClass->load($post,'');
		
		$data = $this->modelClass->insert();
		if($data === true)
			return ['status'=>200,'data'=>['id'=>$this->modelClass->id]];	
		//add error msg
		$errors = !empty($this->modelClass->errors)?$this->modelClass->errors:[];
		return ['status'=>202,'data'=>[],'msg'=>$errors];	
	}


	private function modify(){
		$model = $this->modelClass->findOne(Yii::$app->request->get('id'));
	
		if(empty($model)) 
			return ['status'=>201,'data'=>[]]; 

			
		if( $model->load(Yii::$app->request->get(),'') && $model->save()){
			return	['status'=>200,'data'=>['id'=>Yii::$app->request->get('id')]];
		}else{
			$errors = !empty($model->errors)?$model->errors:[];
			return ['status'=>202,'data'=>[],'msg'=>$errors];
		}



}
	

?>
