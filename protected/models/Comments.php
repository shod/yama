<?php

/**
 * This is the model class for table "news_comments".
 *
 * The followings are the available columns in table 'news_comments':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $entity_id
 * @property integer $user_id
 * @property string $text
 * @property integer $likes
 * @property integer $dislikes
 * @property integer $status
 * @property integer $level
 * @property integer $created_at
 * @property integer $updated_at
 */
class Comments extends ActiveRecord
{

    const STATUS_UNMODERATED = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_UNPUBLISHED = 2;
    const STATUS_DELETED = 3;

    public static $statuses = array(0 => 'Un Moderated', 1 => 'Published', 2 => 'Un Published', 3 => 'Deleted');
    public $userLogin;
    public $owner_id = 0;
    public $level = 0;
    public $cnt = 0;
    public $entity_id;

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'users' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'profile' => array(self::HAS_ONE, 'Users_Profile', array('id' => 'user_id'), 'through' => 'users'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return NewsComments the static model class
     */
    public static function model($className = __CLASS__, $new = false)
    {
        if ($className != __CLASS__) {
            $className = 'Comments_' . $className;
        }
        return parent::model($className, $new);
    }
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('entity_id, user_id', 'required'),
            array('parent_id, entity_id, user_id, likes, dislikes, status, level, created_at, updated_at', 'numerical', 'integerOnly' => true),
            array('text', 'safe'),
            array('text', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
            array('moderate_id', 'numerical'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, userLogin, parent_id, entity_id, user_id, text, likes, dislikes, status, level, created_at, updated_at, moderate_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('Site', 'ID'),
            'parent_id' => Yii::t('Site', 'Parent'),
            'entity_id' => Yii::t('Site', 'Entity'),
            'user_id' => Yii::t('Site', 'User'),
            'text' => Yii::t('Site', 'Text'),
            'likes' => Yii::t('Site', 'Likes'),
            'dislikes' => Yii::t('Site', 'Dislikes'),
            'status' => Yii::t('Site', 'Status'),
            'level' => Yii::t('Site', 'Level'),
            'created_at' => Yii::t('Site', 'Created At'),
            'updated_at' => Yii::t('Site', 'Updated At'),
            'userLogin' => Yii::t('Admin', 'User Name'),
        );
    }

    protected function beforeSave() {
        return parent::beforeSave();
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
        $criteria->with = array('user');
        $criteria->compare('user.login', $this->userLogin, true);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('entity_id', $this->entity_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('likes', $this->likes);
        $criteria->compare('dislikes', $this->dislikes);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('level', $this->level);
        $criteria->compare('created_at', $this->created_at);
        $criteria->compare('updated_at', $this->updated_at);
        $criteria->order = 'created_at DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 40
            )
        ));
    }

}
