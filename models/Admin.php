<?php

namespace app\models;
use Yii;

class Admin extends \yii\db\ActiveRecord
{
	public $reMember = 1;
	public static function tableName(){
		return "{{%admin}}";
	}
	public function rules(){
		return [
			['adminuser','required','message'=>'管理员账号不得为空','on'=>['login','seek']],
			['adminpass','required','message'=>'管理员账号不得为空','on'=>['login']],
			['reMember','boolean','message'=>'记住我们错误','on'=>['login']],
			['adminuser','validataPass','on'=>['login']],
			['adminemail','required','message'=>'邮箱不得为空','on'=>['seek']],
			['adminemail','email','message'=>'邮箱格式不正确','on'=>['seek']],
			['adminuser','validataEmail','on'=>['seek']],
		];
	}
	public function validataPass(){
		if(!$this->hasErrors()){
			$data = self::find()->where('adminuser=:user and adminpass=:pass',[':user'=>$this->adminuser,':pass'=>md5($this->adminpass)])->one();
			if(is_null($data)){
				$this->addError('adminuser','管理员密码不匹配');
			}
		}
	}
	public function validataEmail(){
		if(!$this->hasErrors()){
			$data = self::find()->where('adminuser=:user and adminemail=:email',[':user'=>$this->adminuser,':email'=>$this->adminemail])->one();
			if(is_null($data)){
				$this->addError('adminuser','管理员邮箱不匹配');
			}
		}
	}

	public function login($data){
		$this->scenario = 'login';
		if($this->load($data) && $this->validate()){
			// 开始登录
			$lifetime = $this->reMember*3600*24;
			$session = Yii::$app->session;
			session_set_cookie_params($lifetime);
			$session['admin'] = [
				'adminuser' => $this->adminuser,
				'islogin' => '1',
			];
			self::updateAll(['logintime'=>time(),'loginip'=>ip2long(Yii::$app->request->userIp)],['adminuser'=>$this->adminuser]);
			return (bool)$session['admin']['islogin'];
		}
		return false;
	}

	public function seekpassword($data){
		$this->scenario = 'seek';
		if($this->load($data) && $this->validate()){
			$mail = \Yii::$app->mailer->compose();
	        $mail->setFrom('945903587@qq.com');
	        $mail->setTo('3539306741@qq.com');
	        $mail->setSubject('邮件发送配置');
	        //->setTextBody('Yii中文网教程真好 www.yii-china.com')   //发布纯文字文本
	        $mail->setHtmlBody("<br>Yii2框架真好！www.imooc.test.com") ;   //发布可以带html标签的文本
	        if($mail->send()){
	            echo 'success';
	        }else{
	            echo 'fail';
	        }
		}
	}
}