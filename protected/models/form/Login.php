<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Form_Login extends CFormModel
{
	public $email;
	public $password;
	public $shortSession;
        public $userModel;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('email, password', 'required', 'message' => Yii::t('Site', 'Заполните'), 'except' => 'remindPassword'),
            array('email', 'email', 'message' => Yii::t('Site', 'Email введен не верно')),
            array('email', 'remindEmailCheck', 'message' => Yii::t('Site', 'Write right'), 'on' => 'remindPassword'),
			array('shortSession', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate', 'except' => 'remindPassword'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
                        'email' => Yii::t('Site', 'E-mail'),
                        'password' => Yii::t('Site', 'Password'),
                        'shortSession'=>Yii::t('Site', 'Stay signed in'),
		);
	}

        public function remindEmailCheck($attribute, $params){
            $this->userModel = Users::model()->findByAttributes(array('email'=>$this->email));
            if(!$this->userModel){
                $this->addError('email', Yii::t('Site', 'Неверный email или пароль.'));
            }
        }

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute, $params)
	{
		if(!$this->hasErrors())
		{
			$this->password = trim($this->password);
			$this->_identity=new UserIdentity($this->email,md5($this->password));
			if(!$this->_identity->authenticate()){
                            if($this->_identity->errorCode == UserIdentity::ERROR_USER_BLOCKED){
                                $this->addError('password', Yii::t('Site', 'Пользователь с этим email заблокирован.'));
                            } else {
                                $this->addError('password', Yii::t('Site', 'Неверный email или пароль.'));
                            }
                        }
		}
	}

	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->email,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->shortSession ? 3600 : 3600*24*30; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
