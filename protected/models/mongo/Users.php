 <?php

class Mongo_Users extends EMongoDocument {
    
    public $id;
    public $name;
    public $email;
    public $login;
    public $phone;
    public $date_add;

    /**
     * This method have to be defined in every Model
     * @return string MongoDB collection name, witch will be used to store documents of this model
     */
    public function getCollectionName() {
        return 'users';
    }
	
	public static function getUsers(array $ids){
		$ids = array_unique($ids);
		//$criterea = new EMongoCriteria();
        //$criterea->addCond('id', 'in', $ids);
		//$users = Mongo_Users::model()->findAll($criterea); // временная мера, нужно синхронихировать.
		$users = array();
		$res = array();
		foreach($users as $user){
			$res[$user->id] = $user; 
		}
		if(count($ids) == count($res)){
			return $res;
		}
		$needed = array();
		foreach($ids as $id){
			if(!isset($res[$id])){
				$needed[] = $id;
			}
		}
		$apiUsers = Users::model();
		//$apiUsers->debug = 1;
		$apiUsers = $apiUsers->getInfoByIds('list', array('ids' => $needed));
		
		if(!$apiUsers){
			return $res;
		}
		
		
		
		$apiUsers = $apiUsers->message;
		foreach($apiUsers as $apiUser){
			$user = new Mongo_Users;
			$user->id = $apiUser->id;
			$user->name = $apiUser->fullname;
			$user->email = $apiUser->email;
			$user->date_add = $apiUser->date_add;
			$user->login = $apiUser->login;
			$user->phone = $apiUser->phone;
			$user->save();
			$res[$user->id] = $user;
		}
		return $res;
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
                    array('id, email, name', 'required'),
                    array('id, phone', 'numerical', 'integerOnly'=>true),
                    array('id, email, name, login, phone, date_add', 'safe'),
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