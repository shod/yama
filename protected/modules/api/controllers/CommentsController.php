<?php

/**
 * Work with user comment
 * @package api
 */
class CommentsController extends ERestController
{

    const CONTENT_COMMENTS = 'comments';
    const CONTENT_COMMENT = 'comment';

    private function _getModelName($entity)
    {
        return $entity;
    }

    /**
     * @ignore
     * @param type $id
     */
    public function actionGetComment($id)
    {

    }

    /**
     * @ignore
     * @param type $id
     * @param type $limit
     * @param type $start
     */
    public function actionGetUserList($id, $limit, $start = null)
    {

    }

    /**
     * @ignore
     * @param type $entity
     * @param type $id
     * @param type $limit
     * @param type $start
     */
    public function actionGetEntityList($entity, $id, $limit = null, $start = null)
    {
        $res = array();
        $criteria = new CDbCriteria;
        $criteria->condition = '`t`.`entity_id` = :entity_id and `t`.`status` = :status';
        $criteria->params = array(':entity_id' => $id,
            ':status' => Comments::STATUS_PUBLISHED);
        if ($limit) {
            $criteria->limit = $limit;
        }

        if ($start) {
            $criteria->offset = $start;
        }
        $rawData = Comments::model($entity)->with('user')->findAll($criteria);

        //TODO Как то не правельно related элименты так получать
        foreach ($rawData as $value) {

            $row = array();
            foreach ($value as $key => $attr) {
                $row[$key] = $attr;
            }
			if(isset($value->user)){
				foreach ($value->user as $key => $attr) {
					$row['user'][$key] = $attr;
				}
			}
//            foreach ($value->profile as $key => $attr) {
//                $row['users']['profile'][$key] = $attr;
//            }

            $res[] = $row;
        }

        $content = array(self::CONTENT_COMMENTS => $res, ERestComponent::CONTENT_COUNT => count($res));
        $this->render()->sendResponse($content);
    }

    /**
     * @ignore
     * @param string $entity
     * @param int $id
     * @param int $iser_id
     */
    public function actionGetEntityUserList($entity, $id)
    {
        $userId = (int) Yii::app()->request->getParam('user_id');
        $res = array();
        $criteria = new CDbCriteria;
        $criteria->condition = '`t`.`user_id` = :user_id and `t`.`entity_id` = :entity_id and `t`.`status` != :status';
        $criteria->params = array(':entity_id' => $id,
            ':status' => Comments::STATUS_DELETED,
            ':user_id' => $userId);
        $rawData = Comments::model($entity)->with('user')->findAll($criteria);

        //TODO Как то не правельно related элименты так получать
        foreach ($rawData as $value) {
            $row = array();
            foreach ($value as $key => $attr) {
                $row[$key] = $attr;
            }
            foreach ($value->user as $key => $attr) {
                $row['user'][$key] = $attr;
            }
            $res[] = $row;
        }

        $content = array(self::CONTENT_COMMENTS => $res, ERestComponent::CONTENT_COUNT => count($res));
        $this->render()->sendResponse($content);
    }

    /**
     * @ignore
     * @param string $entity
     * @param int $id
     * @param int $iser_id
     */
    public function actionGetEntityCount($entity)
    {
        $res = array();
		$userId = (int) Yii::app()->request->getParam('user_id');
        $criteria = new CDbCriteria;
        $criteria->select = 'entity_id, count(*) as cnt';
        $criteria->addInCondition('entity_id', $_GET['id']);
        $criteria->condition = '`t`.`status` = :status or (user_id = :user_id and `t`.`status` != :statusUser)';
		$criteria->params = array(':status' => Comments::STATUS_PUBLISHED, ':user_id' => $userId, ':statusUser' => Comments::STATUS_DELETED);
        $criteria->group = '`t`.`entity_id`';
        $rawData = Comments::model($entity)->findAll($criteria);
        foreach ($rawData as $value) {

            $res[] = array('id' => $value->entity_id,
                'count' => $value->cnt);
        }

        $content = array(self::CONTENT_COMMENTS => $res);
        $this->render()->sendResponse($content);
    }

    public function actionPostEntity($entity)
    {
        $comment = Comments::model($entity, true);//new Comments_News();
		
        $comment->attributes = $_POST;
		$comment->parent_id = (isset($_POST['parent_id']) && $_POST['parent_id'] > 0) ? $_POST['parent_id'] : 0;
		if ($comment->save()) {
			$count = Comments::model($entity)->count('parent_id = :parent_id', array(':parent_id' => $comment->parent_id));
			if($comment->parent){
                News::pushComment($comment, $count);
            }
		    $content = array(self::CONTENT_COMMENT => $comment->attributes);
            $this->render()->sendResponse($content);
        } else {
		    throw new ERestException(var_export($comment->getErrors(), 1));
        }
    }

    /**
     * @ignore
     * @param type $id
     * @param type $entity
     * @param type $recursive
     */
    public function actionDeliteComment($id, $entity, $recursive = true)
    {

    }

    /**
     * @ignore
     * @param type $id
     * @param type $entity
     * @param type $params
     */
    public function actionPutComment($id, $entity, $params = array())
    {

    }

}