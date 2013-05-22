<?php

class SiteController extends Controller {

	public $layout = 'yama';
	public $title = 'Яма - бесплатные объявления. Подать объявление на доске частных объявлений бесплатно.';
	public $description = 'Яма - бесплатные объявления. Подать объявление на доске частных объявлений бесплатно.';
	public $keywords = 'бесплатные объявления,подать,доска,частные,минск,беларусь,отдам даром,сайт,дать,подать';

    public function filters() {
        return array(
            'accessControl',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow readers only access to the view file
                'actions' => array('index', 'error', 'search', 'subscribe'),
                'users' => array('*')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }
	
	protected function _prepareData($text, $limit = 10, $offset = 0, $region = 0, $category = 0){
		if(!$entities = Tags::model()->getSearch(array('text' => $text, 'entity_type_id' => 4))){
			return array();
		}
		
		/*if(Yii::app()->request->getParam('debug', 0)){
			d($entities);
		}*/
		
		
		$ids = array();
		$levels = array();
		foreach($entities as $ent){
			$ids[] = $ent->id;
			$levels[$ent->weight] = $ent->weight;
		}
		
		if(!count($ids)){
			return array();
		}
		
		$sIds = implode(',', $ids);
		$condition = "id IN ({$sIds}) AND status = 1";
		if($region){
			$condition .= ' AND region = ' . $region->id;
		}
		if($category){
			$condition .= ' AND category = ' . $category->id;
		}
		$model = Adverts::model()->findAll(
			array('condition' => $condition, 'order' => 'last_up DESC', 'limit' => $limit, 'offset' => $offset));
		$res = array();
		krsort($levels);
		
		foreach($levels as $l){
			foreach($model as $k => $m){
				foreach($entities as $ent){
					if($ent->id == $m->id && $l == $ent->weight){
						$res[] = $m;
						unset($model[$k]);
					}
				}
			}
		}
		return $res;
	}

    public function actionIndex()
	{
		$query = Yii::app()->request->getParam('q', '', 'string');
		$offset = Yii::app()->request->getParam('offset', 0, 'int');
		$user = Yii::app()->request->getParam('user', 0, 'int');
		$category = Yii::app()->request->getParam('category', 0, 'int');
		$region = Yii::app()->request->getParam('region', 0, 'int');
		//$cacheKey = $query . '|#|' . $offset . '|#|' . $user . 'eugen_was_here:)';
		// start to cache!!
		
		if($region){
			$region = Regions::model()->findByPk($region);
		}
		
		if($category){
			$category = Categories::model()->findByPk($category);
		}
	
		if($query){
			//$dependency = new CDbCacheDependency('SELECT last_up FROM adverts order by last_up desc limit 1');
			$this->description = $query;
			$adverts = $this->_prepareData($query, Adverts::LIMIT + 1, $offset, $region, $category);
		} elseif(!$user) {
			
			//$dependency = new CDbCacheDependency('SELECT last_up FROM adverts order by last_up desc limit 1');
			$condition = "status = 1";
			if($region){
				$condition .= ' AND region = ' . $region->id;
			}
			if($category){
				$condition .= ' AND category = ' . $category->id;
			}
			$adverts = Adverts::model()->findAll(
				array(
					'condition' => $condition,
					'order' => 'last_up DESC',
					'limit' => Adverts::LIMIT + 1,
					'offset' => $offset,
				));
		} else {
			//$dependency = new CDbCacheDependency('SELECT last_up FROM adverts where user_id = '.$user.' order by last_up desc limit 1');
			$condition = "user_id = :uId";
			if($region){
				$condition .= ' AND region = ' . $region->id;
			}
			if($category){
				$condition .= ' AND category = ' . $category->id;
			}
			$adverts = Adverts::model()->findAll(
				array(
					'condition' => $condition,
					'order' => 'last_up DESC',
					'limit' => Adverts::LIMIT + 1,
					'offset' => $offset,
					'params' => array(':uId' => $user),
				));
		}
		
		

		$count = count($adverts);
		$else = false;
		if($count > Adverts::LIMIT){
			$else = true;
			array_pop($adverts);
		}
		$offset = Adverts::LIMIT + $offset;
		$uids = array();
		$catIds = array();
		foreach($adverts as $adv){
			$uids[] = $adv->user_id;
			$catIds[] = $adv->category;
		}
		array_unique($catIds);
		
		$users = Mongo_Users::getUsers($uids);

		if(Yii::app()->request->isAjaxRequest){
			$html = $this->renderPartial('list', array(
				'model'=>$adverts,
				'users'=>$users,
			), true, true);
			echo CJSON::encode(array('else' => $else, 'offset' => $offset, 'selector' => '.b-market__middle-i', 'title' => $this->title, 'html' => $html));
			Yii::app()->end();
		}
		
		$html = $this->render('index', array(
			'model'=>$adverts,
			'query'=>$query,
			'users'=>$users,
			'else' => $else,
			'offset' => $offset,
			'region' => $region,
			'category' => $category,
		), true, true);
		//Yii::app()->cache->set($cacheKey, $html, '', $dependency);
		echo $html;
    }
	
	public function actionSubscribe(){
        $text = Yii::app()->request->getParam('text', '', 'subscribe');
		if(Yii::app()->user->isGuest){
			return false;
		}
		$tags = Tags::model()->getTags(array('text' => $text));
		foreach($tags as $tag){
			if(Subscribes::model()->find('user_id = :u and tag_id = :t', array(':u' => Yii::app()->user->id, ':t' => $tag))){
				continue;
			}
			$sub = new Subscribes();
			$sub->user_id = Yii::app()->user->id;
			$sub->tag_id = $tag;
			$sub->save();
		}
		Yii::app()->end();
		
    }

    public function actionError() {
        $this->layout = '';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
}