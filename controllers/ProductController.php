<?php
namespace app\controllers;
use yii\web\Controller;

class ProductController extends Controller{
	public function actionDetail(){
		$this->layout = 'layout2';
		return $this->render('detail');
	}
}