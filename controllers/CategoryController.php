<?php
namespace app\controllers;
use yii\web\Controller;

class CategoryController extends Controller{
	public function actionIndex(){
		$this->layout = 'layout2';
		return $this->render('category');
	}
}