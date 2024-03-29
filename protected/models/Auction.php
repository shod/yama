<?php

/**
 * This is the model class for table "auction".
 *
 * The followings are the available columns in table 'auction':
 * @property integer $id
 * @property integer $user_id
 * @property integer $advert_id
 * @property integer $price
 */
class Auction extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Auction the static model class
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
		return 'auction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, advert_id, price', 'required'),
			array('user_id, advert_id', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical', 'min'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, advert_id, price', 'safe', 'on'=>'search'),
		);
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
	
	protected function beforeSave()
    {
        if ($this->getIsNewRecord()) {
            if ($this->hasAttribute('created_at')) {
                $this->created_at = time();
            }
        }
		if ($this->hasAttribute('updated_at')) {
			$this->updated_at = time();
		}
        return parent::beforeSave();
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'advert_id' => 'Advert',
			'price' => 'Price',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('advert_id',$this->advert_id);
		$criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}