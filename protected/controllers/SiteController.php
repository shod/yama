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
                'actions' => array('index', 'error', 'search', 'subscribe', 'info', 'testnewsearch', 'getmoretags'),
                'users' => array('*')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }

    public function actionIndex()
	{
		$query = Yii::app()->request->getParam('q', '', 'string');
		$query = trim($query);
		$offset = Yii::app()->request->getParam('offset', 0, 'int');
		$user = Yii::app()->request->getParam('user', 0, 'int');
		$category = Yii::app()->request->getParam('category', 0, 'int');
		$region = Yii::app()->request->getParam('region', 0, 'int');
		//$cacheKey = $query . '|#|' . $offset . '|#|' . $user . 'eugen_was_here:)';
		//start to cache!!
		$tags = array();
		
		if($query){
			$userId = (!Yii::app()->user->isGuest) ? Yii::app()->user->id : 0;
			$ser = new Search;
			$ser->value = $query;
			$ser->user_id = $userId;
			$ser->is_good = 1;
			$ser->save();
			//Tags::model()->postSearch(1, array('text' => $query, 'is_good' => 1, 'user' => $userId));
		}
		
		if($region){
			$region = Regions::model()->findByPk($region);
		}
		
		if($category){
			$category = Categories::model()->findByPk($category);
		}
	
		if($query){
			//$dependency = new CDbCacheDependency('SELECT last_up FROM adverts order by last_up desc limit 1');
			$this->description = $query;
			$data = AhimsaSearchService::prepareData($query, Adverts::LIMIT + 1, $offset, $region, $category);
			$adverts = $data['res'];
			$tags = $data['tags'];
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
		$aIds = array();
		$uids = array();
		$catIds = array();
		foreach($adverts as $adv){
			$aIds[] = $adv->id;
			$uids[] = $adv->user_id;
			$catIds[] = $adv->category;
		}
		
		$criterea = new EMongoCriteria();
        $criterea->addCond('id', 'in', $aIds);
		$views = Mongo_Views::model()->findAll($criterea);
		$aViews = array();
		foreach($views as $v){
			$aViews[$v->id] = $v;
		}
		
		array_unique($catIds);
		
		$users = Mongo_Users::getUsers($uids);
		if(Yii::app()->request->isAjaxRequest){
			$selector = '.b-market__middle';
			if(Yii::app()->request->getParam('offset')){
				$selector = '.b-market__middle-i:last';
			}
			$html = $this->renderPartial('list', array(
				'model'=>$adverts,
				'users'=>$users,
				'aViews' => $aViews,
			), true, true);
			$tagsHtml = Widget::create('YamaTags', 'yamatags', array('tags' => $tags))->html(true);
			echo CJSON::encode(array(
				'else' => $else,
				'offset' => $offset,
				'selector' => $selector,
				'title' => $this->title,
				'html' => $html,
				'tags_selector' => '.b-market__tags-line',
				'tags_html' => $tagsHtml,
			));
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
			'aViews' => $aViews,
			'tags' => $tags,
		), true, true);
		//Yii::app()->cache->set($cacheKey, $html, '', $dependency);
		echo $html;
    }
	
	public function actionSubscribe(){
        $text = Yii::app()->request->getParam('text');
		if(Yii::app()->user->isGuest){
			return false;
		}
		
		Api_Subscribe::model()->postNew(Yii::app()->user->id, array('text' => $text));
		
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
	
	public function actionGetMoreTags(){
		if($q = Yii::app()->request->getParam('q', '', 'string')){
			$limit = Yii::app()->request->getParam('limit', 0, 'int');
			$offset = Yii::app()->request->getParam('offset', 0, 'int');
			$category = Yii::app()->request->getParam('category', 0, 'int');
			$region = Yii::app()->request->getParam('region', 0, 'int');
			$res = AhimsaSearchService::prepareData($q, $limit, $offset, $region, $category, 30);
			if(count($res['tags'])){
			
			}
			Widget::create('YamaTags', 'yamaTags', array('limit' => 30, 'tags' => $res['tags']))->html();
		} else {
			Widget::create('YamaTags', 'yamaTags', array('limit' => 30))->html();
		}
	}
}