<?php
namespace app\modules\controllers;
use yii\web\Controller;
use app\models\Admin;
use Yii;
class PublicController extends Controller{
	public function actionLogin(){
		$this->layout = false;
		$model = new Admin();
		if(Yii::$app->request->isPost){
			$post = Yii::$app->request->post();
			if($model->login($post)){
				return $this->redirect(['default/index']);
			}
			// return $this->goBack();
		}
		return $this->render('login',['model'=>$model]);
	}

	public function actionLogout(){
		Yii::$app->session->removeAll();
		if(!isset(Yii::$app->session['admin']['islogin'])){
			$this->redirect(['public/login']);
		}
	} 

	public function actionSeekpassword(){
		$this->layout = false;
		$model = new Admin();
		if(Yii::$app->request->isPost){
			$post = Yii::$app->request->post();
			$model->seekpassword($post);
		}
		return $this->render('seekpassword',['model'=>$model]);
	}
}