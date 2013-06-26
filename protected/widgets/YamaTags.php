<?php
class YamaTags extends QWidget {

	public $viewFile = 'yamatags';
	public $tags = array();
	
	public function init(){
		if(empty($this->tags)){
			$this->tags = Tags::model()->getPopularTags(array('limit' => 14));
		}
		$this->setData(array('tags' => $this->tags));
	}
}