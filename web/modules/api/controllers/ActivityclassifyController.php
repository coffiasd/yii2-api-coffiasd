<?php
namespace app\web\modules\api\controllers;

use Yii;
use app\web\common\ApiController; 
use yii\base\Module; 

class ActivityclassifyController extends ApiController
{
	public $defaultAction='getlist';
	public $modelClass = 'app\models\Activityclassify';

}
