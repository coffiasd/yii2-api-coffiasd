<?php
namespace app\web\common;

class Fileupload{
	//文件数组
	public $file;	

	public function __construct($file=[]){
		$this->file = $file;	
	}
	
	//保存文件
	public function saveFile(){
		if(empty($this->file)||!is_array($this->file))
			return ;
		$filelist=[];	
		//创建文件夹
		$path =$_SERVER['DOCUMENT_ROOT']. "/upload/".date("Y")."/".date("m")."/".date("d");
		$this->createDir($path);	
		foreach($this->file as $key=>$val){
			$filelist[$key] = $this->movefiles($val,$path,$key);	
		}
		return $filelist;
	}

	//保存图片文件
	private function movefiles($file=[],$path){
		$filelist=[];	
		if(empty($file)||!is_array($file))
			return;		

		foreach($file['tmp_name'] as $k=>$v){
			$name=$file['name'][$k];
			//获得后缀名
			$ext = substr(strrchr($name,'.'),1);
			//取得文件名
			$filename = $this->randfilename();

			//移动文件
			if(@move_uploaded_file($v,$path."/".$filename.".".$ext)){
				$filelist[] = "/upload/".date("Y")."/".date("m")."/".date("d")."/".$filename.".".$ext;
			}	
		}
		
		$result = implode($filelist,"#");
		return $result;
	}

	//随机文件名	
	private function randfilename($length=12){
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';	
		$str='';
		for($i=0;$i<$length;$i++){
			$str.= $chars[ mt_rand(0, strlen($chars) - 1) ];  	
		}
		return $str;	
	}
	
	//创建文件夹
	private function createDir($path=''){
		if(empty($path))
			return false;
		if (!file_exists($path)){
			$this->createDir(dirname($path));
			mkdir($path, 0777);
		}   
	} 



}
?>
