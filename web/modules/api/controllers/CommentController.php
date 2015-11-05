<?php
namespace app\web\modules\api\controllers;

use Yii;
use app\web\common\ApiController; 
use yii\base\Module; 

class CommentController extends ApiController
{
    public $defaultAction='getlist';
    public $modelClass = 'app\models\Comment';
    
}