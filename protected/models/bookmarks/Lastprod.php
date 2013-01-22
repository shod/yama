<?php

/**
 * This is the model class for table "bookmarks_bookmark".
 *
 * The followings are the available columns in table 'bookmarks_bookmark':
 * @property integer $user_id
 * @property integer $section_id
 * @property integer $product_id
 * @property string $image
 * @property string $productUrl
 * @property string $title
 * @property double $price
 */
class Bookmarks_Lastprod extends Bookmarks
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return bookmarksBookmark the static model class
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
		return 'bookmarks_lastprod';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, section_id, product_id, image, productUrl, title, price', 'required'),
			array('user_id, section_id, product_id', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('image, productUrl, title', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, section_id, product_id, image, productUrl, title, price', 'safe', 'on'=>'search'),
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'section_id' => 'Section',
			'product_id' => 'Product',
			'image' => 'Image',
			'productUrl' => 'Product Url',
			'title' => 'Title',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('section_id',$this->section_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('productUrl',$this->productUrl,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}