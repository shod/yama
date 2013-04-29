<?php
class YamaTop extends QWidget {

	public $viewFile = 'top';
	public $query = '';
	
	public function init(){
		$this->setData(array('query' => $this->query));
	}

}