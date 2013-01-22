<?php
// yiic mail send --actions=10
class MailCommand extends ConsoleCommand {

    public function actionSend($user_id, $template) {
        $user = Users::model()->findByPk($user_id);
        if(!$user || !$user->email){
            $errors = array('message' => 'User not found or empty email');
            Yii::log($errors, CLogger::LEVEL_ERROR, 'console');
			return true;
        }
        $mailer = Yii::app()->mailer;
//        if($mailer->Host){
//            $mailer->IsSMTP();
//        } else {
            $mailer->IsMail();
//        }

		$mailer->ClearAddresses();
		$mailer->AddAddress($user->email);
        $mailer->FromName = 'Social.Migom.By';
        $mailer->CharSet = 'UTF-8';
        $mailer->Subject = Yii::t('Mail', 'Social.Migom.By');
		$mailer->SingleTo = true;
		$mailer->Mailer = 'mail';
		$mailer->Sender = 'noreply@social.migom.by';
		$mailer->ClearCustomHeaders();
		//$mailer->AddCustomHeader('Return-path: <evgeniy.kazak@gmail.com>');
		$mailer->AddCustomHeader('Errors-To: <noreply@social.migom.by>');
		$mailer->AddCustomHeader('Precedence: bulk');
		//$mailer->AddCustomHeader('From: migom.by<noreply@migom.by>');
		$mailer->AddCustomHeader('Reply-To: <noreply@social.migom.by>');
		//$mailer->AddCustomHeader('Return-Path: <noreply@migom.by>');

        $this->params['user'] = $user;
		$this->params['mailer'] = $mailer;
		try {
            $mailer->getView($template, $this->params);
			$result = $mailer->Send();
        } catch (CException $exc) {
			$errors = array('message' => Yii::t('Command', 'Email error: {ex}', array('{ex}' => $exc->getTraceAsString())));
            Yii::log($errors['message'], CLogger::LEVEL_ERROR, 'console');
			$result = false;
        }
        
        if(!$result){
            $errors = array('message' => Yii::t('Command', 'Email not send (email = :email, template = :template)', array(':email' => $user->email, ':template' => $template)));
            Yii::log($errors['message'], CLogger::LEVEL_ERROR, 'console');
        }
        return $result;
    }
	
	public function actionActivityNotification($user_id, $template){
		$user = Users::model()->findByPk($user_id);
        if(!$user || !$user->email){
            $errors = array('message' => 'User not found or empty email');
            Yii::log($errors, CLogger::LEVEL_ERROR, 'console');
			return true;
        }
        $mailer = Yii::app()->mailer;
//        if($mailer->Host){
//            $mailer->IsSMTP();
//        } else {
            $mailer->IsMail();
//        }

		$mailer->ClearAddresses();
		$mailer->AddAddress($user->email);
        $mailer->FromName = 'Social.Migom.By';
        $mailer->CharSet = 'UTF-8';
		$mailer->SingleTo = true;
		$mailer->Mailer = 'mail';
		$mailer->Sender = 'noreply@social.migom.by';
		$mailer->Subject = Yii::t('Mail', 'Social.Migom.By');
		$mailer->ClearCustomHeaders();
		//$mailer->AddCustomHeader('Return-path: <evgeniy.kazak@gmail.com>');
		$mailer->AddCustomHeader('Errors-To: <noreply@social.migom.by>');
		$mailer->AddCustomHeader('Precedence: bulk');
		//$mailer->AddCustomHeader('From: migom.by<noreply@migom.by>');
		$mailer->AddCustomHeader('Reply-To: <noreply@social.migom.by>');
		//$mailer->AddCustomHeader('Return-Path: <noreply@migom.by>');
        
		$this->params['user'] = $user;
		$this->params['mailer'] = $mailer;
        $mailer->getView($template, $this->params);
        if(!$result = $mailer->Send()){
            $errors = array('message' => Yii::t('Command', 'Email not send (email = :email, template = :template)', array(':email' => $user->email, ':template' => $template)));
            Yii::log($errors, CLogger::LEVEL_ERROR, 'console');
        }
        return $result;
	}
}