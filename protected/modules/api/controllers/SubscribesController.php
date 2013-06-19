<?php

/**
 * Notify user
 * @package api
 */
class SubscribesController extends ERestController
{
	public function actionGetAll(){
		$limit = Yii::app()->request->getParam('id', 0, 'int');
		$else = false;
		$resGroups = Subscribes::model()->findAll(array('group' => 'time_group', 'limit' => $limit+1));
		if(count($resGroups) > $limit ){
			$else = true;
			array_pop($resGroups);
		}
		$users = array();
		$groups = array();
		foreach($resGroups as $rg){
			$users[$rg->user_id] = $rg->user_id;
			$groups[$rg->time_group] = $rg->time_group;
		}
		$sUsers = implode(',', $users);
		$sGroups = implode(',', $groups);
		$model = Subscribes::model()->findAll(array('condition' => 'user_id IN (' . $sUsers . ') AND time_group IN (' . $sGroups . ')'));
		
		$this->render()->sendResponse(array(ERestComponent::CONTENT_RESPONCE => array('subscribes' => $model, 'else' => $else),
			ERestComponent::CONTENT_SUCCESS => true));
		
		Yii::app()->end();
	}
}