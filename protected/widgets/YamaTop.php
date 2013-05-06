<?php
class YamaTop extends QWidget {

	public $viewFile = 'top';
	public $query = '';
	public $region;
	public $category;
	public $regionTitle = '';
	public $categoryTitle = '';
	
	public function init(){
		
		$this->regionTitle = Yii::t('Yama', 'вся Беларусь');
		$this->categoryTitle = Yii::t('Yama', 'Все объявления');
		
		$res = Yii::app()->db->createCommand('
				SELECT * 
				FROM regions
				WHERE id
				IN (
					SELECT region
					FROM adverts
					WHERE STATUS = 1
					GROUP BY region
				)'
		)->query();
		$regions = array();
		foreach($res as $key => $r){
			if($r['id'] == $this->region){
				$this->regionTitle = $r['title'];
				continue;
			}
			$regions[$key]['id']= $r['id'];
			$regions[$key]['title']= $r['title'];
		}
		
		$res = Yii::app()->db->createCommand('
				SELECT * 
				FROM categories
				WHERE id
				IN (
					SELECT category
					FROM adverts
					WHERE STATUS =1 AND category != 0
					GROUP BY category
				)'
		)->query();
		$categories = array();
		foreach($res as $key => $r){
			if($r['id'] == $this->category){
				$this->categoryTitle = $r['title'];
				continue;
			}
			$categories[$key]['id']= $r['id'];
			$categories[$key]['title']= $r['title'];
		}
	
		$this->setData(array('query' => $this->query, 'regions' => $regions, 'categories' => $categories));
	}

}