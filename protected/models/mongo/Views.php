 <?php

class Mongo_Views extends EMongoDocument {
    
    public $id;
    public $count;
    public $last_time;

    /**
     * This method have to be defined in every Model
     * @return string MongoDB collection name, witch will be used to store documents of this model
     */
    public function getCollectionName() {
        return 'views';
    }

    /**
     * We can define rules for fields, just like in normal CModel/CActiveRecord classes
     * @return array
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('id, count, last_time', 'required'),
                    // The following rule is used by search().
                    // Please remove those attributes that should not be searched.
                    array('id, email, name, login, phone, date_add', 'safe', 'on'=>'search'),
            );
    }

    /**
     * This method have to be defined in every model, like with normal CActiveRecord
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}