<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Form_Registration extends CFormModel
{
	public $email;
//	public $agree;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('email', 'required', 'message' => Yii::t('Site', 'Заполните')),
                        array('email', 'email', 'checkPort' => true, 'message' => Yii::t('Site', 'Email введен не верно')),
//			array('agree', 'in', 'range'=>array(1), 'allowEmpty'=>false, 'message' => Yii::t('Site', 'You are not agree with rules?')),
			// password needs to be authenticated
			array('email', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
                        'email' => Yii::t('Site', 'E-mail'),
//			'agree' => Yii::t('Site', 'I agree with the rules'),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
                    $user = Users::model()->find('LOWER(email)=?', array(strtolower($this->email)));
                    if($user){
                        $this->addError('email', Yii::t('Site', 'Пользователь с таким эл. адресом уже существует'));
                    }
		}
	}

        public function registration($identity = null, $service = null){
            $pass = substr(md5(time() . 'eugen was here'), 6, 8); // send to email
            if($service){
                $user = new Users('regByApi');
                $user->password = $pass;
                $user->attributes = $identity->getAttributes();
                if($user->save()){
                    $identity->setId($user->id);
                    $profile = new Users_Profile();
                    $profile->attributes = $identity->getAttributes();
                    if($identity->getAttribute('avatar')){
                        // upload avatar to self server
                        $profile->avatar = UserService::uploadAvatarFromService($user->id, $identity->getAttribute('avatar'));
                    }else{
                        $gravatarHash = ($user->email)? $user->email:  rand(0, 99999999);
                        $profile->avatar = UserService::uploadAvatarFromEmail($user->id, $user->email);
                    }
                    $profile->sex = $identity->getAttribute('sex');
                    $profile->user_id = $user->id;
                    $userProviders = new Users_Providers();
                    $userProviders->attributes = $identity->getAttributes();
                    $userProviders->user_id = $profile->user_id;
                    $userProviders->provider_id = array_search($service, Users_Providers::$providers);

                    $profile->save();
                    $userProviders->save();
                } else {
                    return $user;
                }
            } else {
                $user = new Users('simpleRegistration');
                $user->email = $this->email;
                $user->password = $pass;
                if(!$user->save()){
                    return false;
                }
                $profile = new Users_Profile();
                $profile->user_id = $user->id;
                $profile->avatar = UserService::uploadAvatarFromEmail($user->id, $user->email);
                $profile->save();
                if(!$identity){
                    $identity = new UserIdentity($user->email, $user->password);
                    $identity->setFirstTime();
                    $identity->authenticate();
                }
            }
            if($user->email){
                $mail = new Mail();
                $mail->send($user, 'registration', array('password' => $pass), true);
            }
			News::pushHellow($user);
            return $identity;
        }
}
