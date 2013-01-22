<?php

/**
 * @example yiic likes updatestatistics --models=comments_news --models=comments_news2...
 */
class LikesCommand extends ConsoleCommand
{

    public $fromQueue = false;

    public function actionUpdateStatistics(array $models)
    {
        foreach ($models as $model) {
            $this->_workUpdateStatistics($model);
        }
    }

    protected function _workUpdateStatistics($model)
    {
        $obj = $this->_getLikeModel($model);
        $criteria = new EMongoCriteria();
        $criteria->refresh = 1;

        foreach ($obj->findAll($criteria) as $like) {
            $mysqlModel = $this->_getModel($model);
            $mysqlRes = $mysqlModel->findByPk($like->entity_id);
            if ($mysqlRes) {
                $mysqlRes->likes = $like->likes;
                $mysqlRes->dislikes = $like->dislikes;
                $mysqlRes->save();
            }
            $like->setScenario('console');
            $like->refresh = 0;
            $like->save();
        }
    }

    protected function _getLikeModel($modelName)
    {
        return Likes::model($modelName);
    }

    protected function _getModel($model)
    {
        return $model::model();
    }

}