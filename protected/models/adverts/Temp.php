<?php

/**
 * This is the model class for table "adverts".
 *
 * The followings are the available columns in table 'adverts':
 * @property integer $id
 * @property string $title
 * @property string $text
 */
class Adverts_Temp extends ActiveRecord
{

	public $free;
	public $phone_postfix;

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
		return 'adverts_temp';
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
			array('price, currency, product_id, region, category', 'numerical'),
			array('name', 'length', 'max'=>30),
			array('price', 'price', 'except' => array('new')),
			array('image', 'length', 'max'=>255),
			array('phone', 'phone', 'length'=>9),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, region, category, description, text', 'safe', 'on'=>'search'),
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
		if(strlen($phone) != $params['length'] && strlen($phone) > 0){
			$this->addError('phone_postfix', Yii::t('Site', 'Телефон введен не верно'));
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'description' => Yii::t('Adverts', 'Краткое описание'),
			'text' => Yii::t('Adverts', 'Описание'),
			'product_id' => Yii::t('Adverts', 'Продукт'),
			'free'		=> Yii::t('Adverts', 'Даром'),
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text',$this->text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}