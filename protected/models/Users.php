<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $email
 * @property integer $status
 * @property integer $date_add
 * @property integer $date_edit
 */
class Users extends ActiveRecord
{

    const AVATAR_PATH = '/images/users';

    public static $roles = array(1         => 'user', 2         => 'moderator', 3         => 'administrator');
    public static $statuses = array(1 => 'active', 2 => 'noactive', 3 => 'ban');
    public $newpassword;
	public $repassword;
    public $old_password;
    public $reemail;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('login, password, email, status, date_add, date_edit, role', 'required', 'except' => array('regByApi', 'simpleRegistration', 'general_update')),
            array('email', 'required', 'on' => array('simpleRegistration')),
//                        array('password', 'required', 'on' => array('general_update')),
            array('email, reemail', 'email'),
            array('reemail', 'compareEmail', 'on' => 'general_update'),
            array('email', 'unique', 'message' => 'Пользователь с таким email уже зарегистрирован'),
            array('status, date_add, date_edit', 'numerical', 'integerOnly' => true),
            array('login, email', 'length', 'max' => 255),
            array('password', 'length', 'max' => 32, 'min' => 6),
            array('repassword', 'compare', 'compareAttribute' => 'newpassword', 'on' => 'general_update', 'message' => Yii::t('Site', 'Введенные пароли не совпадают')),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, login, password, email, status, date_add, date_edit, role', 'safe', 'on' => 'search'),
            array('login, email', 'safe', 'on' => 'regByApi'),
            array('password, email, reemail, repassword, newpassword', 'safe', 'on' => 'general_update'),
        );
    }

//        fsockopen("mx1.hotmail.com", 25, $errno , $errstr, 15)
    public function compareOldPass(){
        if($this->password){
            if(md5($this->old_password) != $this->oldAttributes['password']){
                $this->addError('old_password', Yii::t('Profile', 'Пароль введен не верно'));
            }
        }
    }

    public function compareEmail(){
        if($this->email != $this->oldAttributes['email']){
            if($this->email != $this->reemail){
                $this->addError('reemail', Yii::t('Profile', 'Не верно введено поле email'));
            }
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'profile' => array(self::HAS_ONE, 'Users_Profile', 'user_id'),
            'google_oauth' => array(self::HAS_ONE, 'Users_Providers_Google', 'user_id'),
            'vkontakte' => array(self::HAS_ONE, 'Users_Providers_Vkontakte', 'user_id'),
            'facebook' => array(self::HAS_ONE, 'Users_Providers_Facebook', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'           => 'ID',
            'login'        => Yii::t('Site', 'Login'),
			'nickName'     => Yii::t('Site', 'Имя пользователя'),
            'password'     => Yii::t('Site', 'Новый пароль'),
            'email'        => Yii::t('Site', 'Логин (эл. почта)'),
            'reemail'      => Yii::t('Site', 'Повторите'),
            'status'       => Yii::t('Site', 'Status'),
            'date_add'     => Yii::t('Site', 'Date Add'),
            'date_edit'    => Yii::t('Site', 'Date Edit'),
            'repassword'   => Yii::t('Site', 'Повторите'),
            'old_password' => Yii::t('Profile', 'Старый пароль'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('login', $this->login, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('role', $this->role);
        $criteria->compare('status', $this->status);
        $criteria->compare('date_add', $this->date_add);
        $criteria->compare('date_edit', $this->date_edit);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function beforeSave()
    {
        parent::beforeSave();
        if ($this->isNewRecord) {
            $this->role      = array_search('user', self::$roles);
            $this->date_add  = time();
            $this->date_edit = $this->date_add;
            $this->password  = md5($this->password);
            if ($this->scenario == 'regByApi') {
                $this->status = array_search('active', self::$statuses);
            } elseif ($this->scenario == 'simpleRegistration') {
                $this->status = array_search('noactive', self::$statuses);
            }
            if (!$this->login && $this->email) {
                $name        = explode('@', $this->email);
                $this->login = $name[0];
            }
        } else {
            if ($this->scenario == 'general_update' && $this->newpassword) {
                $this->password = md5($this->newpassword);
            }
            if (!$this->password) {
                $this->password = $this->oldAttributes['password'];
            }
            if ($this->oldAttributes['email']) {
                $this->email = $this->oldAttributes['email'];
            } elseif($this->email){
                $mail = new Mail();
                $mail->send($this, 'registration', array(), true);
                $this->status = 2;
            }
        }
        $this->email = strtolower($this->email);

        $this->date_edit = time();
        return true;
    }

    public function remindPassword()
    {
        if (!$this->email) {
            return false;
        }
        $mail = new Mail();
        $pass = substr(md5(time() . $this->email . 'remind migom pass'), 6, 8);
        $mail->send($this, 'remindPassword', array('password' => $pass), true);
        $this->password = md5($pass);
        $this->save();
        return true;
    }

    public function getCountComments()
    {
        $count = Yii::app()->cache->get('comments_count_user_' . $this->id);
        if (!$count) {
            $count = Comments_News::model()->count('user_id = :user_id', array(':user_id' => $this->id));
            Yii::app()->cache->set('comments_count_user_' . $this->id, $count, 60 * 10);
        }
        return $count;
    }

    public function getAvatarPath($temp = false){
        if(!$this->id){
            return false;
        }
        $path = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..';
        $destination = $path . Users::AVATAR_PATH . DIRECTORY_SEPARATOR . $this->id  . DIRECTORY_SEPARATOR;
        if($temp){
            return $destination . 'avatar-temp.jpg';
        }
        return $destination . 'avatar.jpg';
    }

    public function getAvatarUrl($temp = false){
        if(!$this->id){
            return false;
        }
        $destination = Users::AVATAR_PATH.'/'.$this->id.'/';
        if($temp){
            return $destination . 'avatar-temp_96x96.jpg';
        }
        return $destination . 'avatar.jpg';
    }

    public function afterDelete()
    {
        $this->profile->delete();
        parent::afterDelete();
    }
}