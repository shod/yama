<?php

class Likes extends EMongoDocument
{

    public $entity_id;
    public $likes = 0;
    public $dislikes = 0;
    public $users;
    public $refresh;

    public function primaryKey()
    {
        return 'entity_id';
    }

    public function embeddedDocuments()
    {
        return array(
                // property name => embedded document class name
//            'users' => 'LikesUsers'
        );
    }

    public function behaviors()
    {
        return array(
            array(
                'class' => 'core.extensions.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'users', // name of property
                'arrayDocClassName' => 'Likes_Embidded_Users' // class name of documents in array
            ),
        );
    }

    /**
     * This method have to be defined in every Model
     * @return string MongoDB collection name, witch will be used to store documents of this model
     */
    public function getCollectionName()
    {
        return 'likes';
    }

    /**
     * We can define rules for fields, just like in normal CModel/CActiveRecord classes
     * @return array
     */
    public function rules()
    {
        return array(
            array('entity_id', 'required'),
//            array('id, likes, dislikes', 'integerOnly' => true),
        );
    }

    /**
     * This method have to be defined in every model, like with normal CActiveRecord
     */
    public static function model($className = __CLASS__)
    {
        if ($className != __CLASS__) {
            $className = 'Likes_' . $className;
        }
        return parent::model($className);
    }

    public function setWeightInc($weight, $isNew = true)
    {
		if ($weight > 0) {
			$this->likes++;
		} else {
			$this->dislikes++;
		}
		if(!$isNew){
			if ($weight > 0) {
				$this->dislikes--;
			} else {
				$this->likes--;
			}
		}
    }

    public function beforeSave() {
        if($this->getScenario() != 'console'){
            $this->refresh = 1;
        }
        return parent::beforeSave();
    }

}