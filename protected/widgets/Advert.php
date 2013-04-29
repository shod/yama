<?php
class Advert extends QWidget {

	public $viewFile = 'advert';
	public $id;
	
	public function init(){
		$model = Adverts::model()->findByPk($this->id);
		$imageDir = Yii::app()->getBasePath() . '/..' . Adverts::IMAGE_PATH . '/' . $this->id . '/';
		$images = FileServices::getImagesFromDir($imageDir);

		$this->setData(array(
			'model'=>$model,
			'images'=>$images,
		));
	}

}