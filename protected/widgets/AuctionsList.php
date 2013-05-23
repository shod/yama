<?php
class AuctionsList extends QWidget {

	public $viewFile = 'auction';
	public $id = 'auctions_list_widget';
	public $advert_id;
	public $update = false;
	public $advert;
	
	public function init(){
		$advert = $this->advert;//Adverts::model()->findByPk($this->advert_id); //Adverts::$currencySymbol[$model->currency];
		
		$cache_key = $this->id . '_' . $advert->id . '_' . $this->update;
		
		$data = Yii::app()->fileCache->get($cache_key);
		if(!$data){
			$auctFlag = true;
			$auction = Auction::model()->findAll('advert_id = :id', array(':id' => $advert->id));
			
			$uids = array();
			foreach($auction as $auct){
				$uids[$auct->user_id] = $auct->user_id;
				if($auct->user_id == Yii::app()->user->id){
					$auctFlag = false;
				}
			}
			$users = Mongo_Users::getUsers($uids);
			
			$data = array(
				'auctFlag'=>$auctFlag,
				'auction'=>$auction,
				'users' => $users,
				'currency' => Adverts::$currencySymbol[$advert->currency],
			);
			$cacheData = array(
				'auctFlag'=>$auctFlag,
				'auction'=>$auction,
				'users' => $users,
				'currency' => Adverts::$currencySymbol[$advert->currency],
			);
			Yii::app()->cache->set($cache_key, $cacheData, '', new CDbCacheDependency('select created_at from auction where advert_id = ' . $advert->id . ' order by created_at desc'));
		}

		$this->setData($data);
	}

}