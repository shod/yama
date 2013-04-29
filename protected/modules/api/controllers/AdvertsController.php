<?php

/**
 * Notify user
 * @package api
 */
class AdvertsController extends ERestController
{
	public function actionGetByUser($id){
		$criteria = array(
			'condition' => 'user_id = :uId', 
			'params' => array(':uId' => $id),
			'order' => 'last_up desc',
		);
		$limit = Yii::app()->request->getParam('limit', 0, 'int');
		$offset = Yii::app()->request->getParam('offset', 0, 'int');
		if($limit){
			$criteria['limit'] = $limit;
			$criteria['offset'] = $offset;
		}
		
		$adverts = Adverts::model()->with('auctions')->findAll($criteria);
		$res = array();
		foreach($adverts as $advert){
			$res[$advert->id] = $advert->attributes;
			$res[$advert->id]['auctions'] = array();
			foreach($advert->auctions as $auction){
				$res[$advert->id]['auctions'][] = $auction->attributes;
			}
		}
		$this->render()->sendResponse(array(ERestComponent::CONTENT_RESPONCE => $res,
			ERestComponent::CONTENT_SUCCESS => true));
	}
}