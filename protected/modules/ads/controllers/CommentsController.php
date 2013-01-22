<?php

class CommentsController extends Controller
{
    public function actionIndex(){
        $this->render('index');
    }

    public function actionList($model){
        $modelTitle = $model;
        $model= Comments::model($modelTitle);
		$model->unsetAttributes();
        $model->scenario = 'search';
        if(isset($_GET['Comments_News'])){
            $model->attributes = $_GET['Comments_News'];
        }

        $this->render('list', array('model' => $model, 'modelTitle' => $modelTitle));
    }

    public function actionTree($model, $id){
        $modelTitle = $model;
        $model= Comments::model($modelTitle);
        $model = $model->findByPk($id);
        if($model->status == Comments::STATUS_UNMODERATED){
            $model->status = Comments::STATUS_UNPUBLISHED;
            $model->moderate_id = Yii::app()->user->id;
            $model->save();
        }

        $this->renderPartial('tree', array('model' => $model, 'modelTitle' => $modelTitle));
    }

    public function actionApproove($model, $id){
        $modelTitle = $model;
        $model= Comments::model($modelTitle);
        $model = $model->findByPk($id);
        $model->status = Comments::STATUS_PUBLISHED;
        if(isset($_POST[get_class($model)])){
            $model->attributes = $_POST[get_class($model)];
        }
        $model->moderate_id = Yii::app()->user->id;
        $count = Comments::model($modelTitle)->count('parent_id = :parent_id', array(':parent_id' => $model->parent_id));
        if($model->save()){
            if($model->parent){
                News::pushComment($model, $count);
            }
        }else{
            d($model->getErrors());
        }
    }

    public function actionSave($model, $id){
        $modelTitle = $model;
        $model= Comments::model($modelTitle);
        $model = $model->findByPk($id);
        $model->attributes = $_POST[get_class($model)];
        $model->moderate_id = Yii::app()->user->id;
        $model->save();
    }

    public function actionDelete($model, $id){
        $modelTitle = $model;
        $model= Comments::model($modelTitle);
        $model = $model->findByPk($id);
        $model->status = Comments::STATUS_DELETED;
        $model->moderate_id = Yii::app()->user->id;
        $model->save();
    }
}
