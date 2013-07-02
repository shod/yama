<?php
class YamaTop extends QWidget {

	public $viewFile = 'top';
	public $query = '';
	public $regionTitle = '';
	public $categoryTitle = '';
	public $region_id;
	public $category_id;
	public $region = false;
	public $category = false;
	
	
	public function init(){
		
		$this->regionTitle = Yii::t('Yama', 'Беларусь');
		$this->categoryTitle = Yii::t('Yama', 'Все рубрики');
		
		$res = Yii::app()->cache->get('all_select_regions');
		if(!$res){
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
			)->queryAll();
			Yii::app()->cache->set('all_select_regions', $res, 600);
		}
		
		$regions = array();
		
		foreach($res as $key => $r){
			if($r['id'] == $this->region_id){
				$this->regionTitle = $r['title'];
			}
			$regions[$key]['id']= $r['id'];
			$regions[$key]['title']= $r['title'];
		}
		$res = Yii::app()->cache->get('all_select_categories');
		if(!$res){
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
			)->queryAll();
			Yii::app()->cache->set('all_select_categories', $res, 600);
		}
		
		$categories = array();
		foreach($res as $key => $r){
			if($r['id'] == $this->category_id){
				$this->categoryTitle = $r['title'];
			}
			$categories[$key]['id']= $r['id'];
			$categories[$key]['title']= $r['title'];
		}
	
		$this->setData(array('query' => $this->query, 'regions' => $regions, 'categories' => $categories));
	}

}