<?php

/**
 * This is the model class for table "adverts".
 *
 * The followings are the available columns in table 'adverts':
 * @property integer $id
 * @property string $title
 * @property string $text
 */
class Adverts extends ActiveRecord
{
	const IMAGE_PATH = '/images/ahimsa';
	const LIMIT = 20;
	public static $currency = array(0 => 'USD', 1 => 'BYR', 2 => 'RUR');
	public static $currencySymbol = array(0 => '$', 1 => 'BYR', 2 => 'RUR');
	public static $size = array('min' => array('x' => 1500, 'y' => 1500));
	public static $publicSizeTypes = array(
		'mini' => array('x' => 85, 'y' => 65, 'op' => 'crop'),
		'thumbs' => array('x' => 100, 'y' => 63, 'op' => 'auto'),
		'index' => array('x' => 210, 'y' => 500, 'op' => 'auto'),
		'view' => array('x' => 640, 'y' => 1500, 'op' => 'min'),
	);
	public $free;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Adverts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'adverts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text, email, description', 'required', 'except' => array('new')),
			array('text', 'length', 'max'=>4500),
			array('description', 'length', 'max'=>500),
			array('email', 'email'),
			array('text, description, name', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
			array('price, last_up', 'numerical'),
			array('name', 'length', 'max'=>30),
			array('image', 'length', 'max'=>255),
			array('phone', 'phone', 'length'=>9),
			array('price', 'price', 'except' => array('new', 'specialUpdate')),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, region, category, description, text', 'safe', 'on'=>'search'),
			array('description, region, category, text, price, name, email, free, currency, product_id, image, phone', 'safe', 'on'=>'update'),
			array('id, region, category, description, text, price, name, email, free, currency, product_id, image, user_id, phone', 'safe', 'on'=>'clone'),
		);
	}
	
	public function price($attribute,$params)
	{
		if(!$this->price && !$this->free){
			$this->addError($attribute, Yii::t('Site', 'Если отдаете даром, поставьте галочку'));
		} elseif($this->free) {
			$this->price = 0;
		}
	}
	
	public function phone($attribute,$params)
	{
		$phone = str_replace(array('(',')','+375','-'), '', $this->phone);
		if(strlen($phone) != $params['length'] && strlen($phone) > 0 && $phone){
			$this->addError($attribute, Yii::t('Site', 'Телефон введен не верно'));
		}
		$this->phone = $phone;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'auctions' => array(self::HAS_MANY, 'Auction', 'advert_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'text' => 'Text',
		);
	}
	
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->image && count(explode('/', $this->image))){
				$this->image = array_pop(explode('/', $this->image));
			}
			if($this->isNewRecord)
			{
				$this->last_up = $this->created_at;
			}
			return true;
		}
		else
			return false;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('text',$this->text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}