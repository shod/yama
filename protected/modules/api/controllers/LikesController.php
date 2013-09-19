<?php

class LikesController extends Controller
{

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow readers only access to the view file
                'actions' => array('voiceup', 'voicedown'),
                'users' => array('*')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }

    /**
     * Post like
     * @param int $id
     * @param int $entity_type_id
     * @return false
     */
    public function actionVoiceup()
    {
        $entity = EntityServices::getEntityLabel((int)$_GET['entity_type_id']);
        $id = (int) $_GET['id'];
        $params['id'] = $id;
        $params['user_id'] = Yii::app()->user->id;
		$entity_id = Yii::app()->request->getParam('entity_id', 0, 'int');

		$dinamicCashName = $id . Yii::app()->user->id . $entity;
        $cacheKey = 'likesapi_up' . $dinamicCashName;
		$cacheDeleteKey = 'likesapi_down' . $dinamicCashName;
        if(Yii::app()->cache->get($cacheKey)){
            die(CJSON::encode(array('success' => false)));
        }
		Widget::create('WComments', 'wcomments', array('entity' => array_pop(explode('_', $entity)), 'id' => $entity_id))->deleteCache();
		
        Yii::app()->cache->set($cacheKey, 1, 43200);//60*60*12
		Yii::app()->cache->delete($cacheDeleteKey);
        
		$model = Likes::model();
		$model->debug =1 ;
		$a = $model->postLike($entity, $params);
		$isNew = true;
		$success = false;
		d($a);
		die;
		if(is_object($a) && isset($a->update) && $a->update == true){
			$isNew = $a->new;
			$success = $a->update;
		}
		echo CJSON::encode(array('success' => $success, 'new' => $isNew));
    }

    /**
     * Post dislike
     * @param int $id
     * @param string $entity
     * @return false
     */
    public function actionVoicedown()
    {
	
        $entity = EntityServices::getEntityLabel((int)$_GET['entity_type_id']);

        $id = (int) $_GET['id'];
        $params['id'] = (int) $id;
        $params['user_id'] = Yii::app()->user->id;
		$entity_id = Yii::app()->request->getParam('entity_id', 0, 'int');
		
		$dinamicCashName = $id . Yii::app()->user->id . $entity;
        $cacheKey = 'likesapi_down' . $dinamicCashName;
		$cacheDeleteKey = 'likesapi_up' . $dinamicCashName;
        
		if(Yii::app()->cache->get($cacheKey)){
			die(CJSON::encode(array('success' => false)));
        }
		
		Widget::create('WComments', 'wcomments', array('entity' => array_pop(explode('_', $entity)), 'id' => $entity_id))->deleteCache();
		
        Yii::app()->cache->set($cacheKey, 1, 43200);//60*60*12
		Yii::app()->cache->delete($cacheDeleteKey);
        $model = Likes::model();
        $a = $model->postDislike($entity, $params);
		$isNew = true;
		$success = false;
		if(is_object($a) && isset($a->update) && $a->update == true){
			$isNew = $a->new;
			$success = $a->update;
		}
		echo CJSON::encode(array('success' => $success, 'new' => $isNew));
    }



}