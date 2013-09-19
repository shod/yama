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
		$with = Yii::app()->request->getParam('with', 0, 'list', array('auctions'));
		if($limit){
			$criteria['limit'] = $limit;
			$criteria['offset'] = $offset;
		}
		$adverts = Adverts::model();
		if($with){
			$adverts = Adverts::model()->with('auctions');
		}
		$adverts = $adverts->findAll($criteria);
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
	
	public function actionGetAdverts(){
		$ids = Yii::app()->request->getParam('ids');
		$res = Adverts::model()->findAll('id IN ('.implode(',', $ids).') AND status = 1');
		$this->render()->sendResponse(array(ERestComponent::CONTENT_RESPONCE => $res,
			ERestComponent::CONTENT_SUCCESS => true));
	}
	
	public function actionGetSuggest() {
		$search = Yii::app()->request->getParam('search');
		$adverts = AhimsaSearchService::prepareData($search, 4);
		$adverts = array_slice( $adverts['res'], 0, 4 );
		if(count($adverts)){
			$this->render()->sendResponse(array(ERestComponent::CONTENT_RESPONCE => $adverts,
				ERestComponent::CONTENT_SUCCESS => true));
		} else {
			$this->render()->sendResponse(array(ERestComponent::CONTENT_SUCCESS => false));
		}
		
	}
}