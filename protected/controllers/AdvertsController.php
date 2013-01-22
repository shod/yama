<?php

class AdvertsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='user';
	public $title='adverts';



	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Adverts;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Adverts']))
		{
			$model->attributes=$_POST['Adverts'];
			if($model->save()){
				$path = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..';
				$folder = $path . Adverts::IMAGE_PATH . DIRECTORY_SEPARATOR . $model->id . DIRECTORY_SEPARATOR;
				$tempFolder = $path . Adverts::IMAGE_TEMP_PATH . DIRECTORY_SEPARATOR . '0' . DIRECTORY_SEPARATOR;
				
				$oldUmask = umask ();
				umask ( 0 );
				$res = @mkdir ( $folder, 0775 );
				umask ( $oldUmask );
				$oldUmask = umask ();
				umask ( 0 );
				$res = @mkdir ( $originFolder, 0775 );
				umask ( $oldUmask );
				$oldUmask = umask ();
				d(YII_DEBUG);
				d($tempFolder);
				d($folder);
					
				
				ImagesService::copyImages($tempFolder, $folder);
				echo '11111111';
				die;
				$this->redirect(array('view','id'=>$model->id));
			}
				
		} else {
			$path = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..';
			$folder = $path . Adverts::IMAGE_TEMP_PATH . DIRECTORY_SEPARATOR . '0';
			ImagesService::clearDir($folder);
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Adverts']))
		{
			$model->attributes=$_POST['Adverts'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Adverts');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionUploadImage()
	{
        Yii::import("core.extensions.EAjaxUpload.qqFileUploader");
		$userId = 0;//(int)Yii::app()->user->id;
        $path = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..';
        $folder = $path . Adverts::IMAGE_TEMP_PATH . DIRECTORY_SEPARATOR . $userId . DIRECTORY_SEPARATOR;
		
		$allowedExtensions = array("jpg","jpeg","png");//array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 2 * 1024 * 1024;// maximum file size in bytes
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);

		$oldUmask = umask ();
        umask ( 0 );
        $res = @mkdir ( $folder, 0777 );
        umask ( $oldUmask );
        $oldUmask = umask ();

		$originFolder = $folder.'origin'.DIRECTORY_SEPARATOR;
		$oldUmask = umask ();
        umask ( 0 );
        $res = @mkdir ( $originFolder, 0777 );
        umask ( $oldUmask );
        $oldUmask = umask ();
		
		$result = $uploader->handleUpload($folder, true);
		$image = Yii::app()->image->load($folder.$result['filename']);
		$origin = clone($image);
		$origin->save($originFolder.$result['filename']);
		$image->resize(150, 600);
		$image->save();
        
		$return = '{"success":true,"filename":"'.$result['filename'].'"}';
		
        echo $return;// it's array
        Yii::app()->end();
    }
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Adverts('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Adverts']))
			$model->attributes=$_GET['Adverts'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Adverts::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='adverts-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
