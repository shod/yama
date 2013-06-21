<?php
class YamaTags extends QWidget {

	public $viewFile = 'yamatags';
	public $query = '';
	public $limit = 10;
	
	public function init(){
		if(Yii::app()->request->getParam('q', '', 'string')){
			$tags = Tags::model()->getNearTags(array('limit' => 14, 'text' => trim(Yii::app()->request->getParam('q', '', 'string'))));
		} else {
			$tags = Tags::model()->getPopularTags(array('limit' => 14));
		}

		$this->setData(array('tags' => $tags));
	}

}