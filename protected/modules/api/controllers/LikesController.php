<?php

/**
 * Entity like
 * @package api
 */
class LikesController extends ERestController
{

    const CONTENT_IS_UPDATE = 'update';

    /**
     *
     * @param string $entity
     * @param array $id array of int array(1,23,34)
     */
    public function actionGetEntityList($entity)
    {
        if(!is_array($_GET['id'])){
            throw new ERestException(Yii::t('Likes', "Param '{param}' is not array", array('{param}' => 'id')));
        }
        array_map('intval', $_GET['id']);
        $criteria = new EMongoCriteria();
        $criteria->entity_id('in', $_GET['id']);

        try {
            /* @var $res Likes */
            $res = Likes::model($entity)->findAll($criteria);
        } catch (Exception $exc) {
            throw new ERestException(Yii::t('Likes', "Entity '{entity}' is not exist", array('{entity}' => $entity)));
        }



        $content = array(ERestComponent::CONTENT_ITEMS => $res, ERestComponent::CONTENT_COUNT => count($res));
        $this->render()->sendResponse($content);
    }

    public function actionGetEntity($entity, $id)
    {
        /* @var $res Likes */
        $res = Likes::model($entity)->findAll(array('entity_id' => $id));

        $content = array(ERestComponent::CONTENT_ITEM => $res);
        $this->render()->sendResponse($content);
    }

    /**
     * Like entity
     * @param string $entity
     * @param int $id
     * @param int $user_id
     * @access (is_int($id))
     */
    public function actionPostLike($entity)
    {
        $res = $this->_likeUpdate($_REQUEST['id'], $entity, 1);
        $this->render()->sendResponse($res);
    }

    /**
     * Like disentity
     * @param string $entity
     * @param int $id
     * @param int $user_id
     * @access (is_int($id))
     */
    public function actionPostDislike($entity)
    {
        $res = $this->_likeUpdate($_REQUEST['id'], $entity, -1);
        $this->render()->sendResponse($res);
    }

    private function _likeUpdate($entity_id, $entity, $weight)
    {
        //assert(is_int($entity_id));
		$isNew = true;
        $userId = (int) $_REQUEST['user_id'];
        $comment = $entity::model()->findByPk($entity_id);
        if(!$comment){
            throw new ERestException(Yii::t('Likes', "Have not entity #{id}", array('{id}' => $entity_id)));
        }
        try {
             /* @var $likes Likes */
            if ($likes = Likes::model($entity)->findByPk($entity_id)) {
                foreach ($likes->users as $user) {
                    if ($user->id == $userId) {
						if($user->weight != $weight){
							$user->weight = $weight;
							$isNew = false;
						}else{
							return array(self::CONTENT_IS_UPDATE => false);
						}
					}
                }
            } else {
                $model = $this->_getModelName($entity);
                $likes = new $model();
                $likes->entity_id = $entity_id;
            }
        } catch (Exception $exc) {
            throw new ERestException(Yii::t('Likes', "Entity '{entity}' is not exist", array('{entity}' => $model)));
        }
		if($isNew){
			$userModel = Users::model()->findByPk($userId);
			if(!$userModel){
				throw new ERestException(Yii::t('Likes', "User #{id} not found", array('{id}' => $userId)));
			}
			$user = new Likes_Embidded_Users();
			$user->id = $userId;
			$user->login = $userModel->login;
			$user->weight = $weight;

			$likes->users[] = $user;
		}
			
        $likes->setWeightInc($weight, $isNew);
        if($likes->save()){
			if($weight > 0){
				$comment->likes++;
			}else{
				$comment->dislikes++;
			}
			if(!$isNew){
				if($weight > 0){
					$comment->dislikes--;
				}else{
					$comment->likes--;
				}
			}
			$comment->save();
				
            News::pushLike($comment, $likes);
            return array(self::CONTENT_IS_UPDATE => true, 'new' => $isNew);
        }  else {
            throw new ERestException(Yii::t('Likes', $likes->getErrors()));
        }
        return array(self::CONTENT_IS_UPDATE => false);
    }

    /**
     * Create model name above inner rule
     * @param type $entity
     * @return string
     */
    private function _getModelName($entity)
    {
//        $connection = Yii::app()->cache->get($this->key);
//        return 'Likes_' . $connection['name'] . '_' . $entity;
        return 'Likes_' . $entity;
    }

}
