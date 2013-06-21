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
                'actions' => array('index', 'error', 'search', 'subscribe', 'info'),
                'users' => array('*')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }
	
	protected function _prepareData($text, $limit = 10, $offset = 0, $region = 0, $category = 0){
		if(!$entities = Tags::model()->getSearch(array('text' => $text, 'entity_type_id' => 4, 'user' => Yii::app()->user->id))){
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
		$topLevel = false;
		if(count($levels) > 1){
			$topLevel = count($levels);
		}
		foreach($levels as $lk => $l){
			foreach($model as $k => $m){
				foreach($entities as $ent){
					if($ent->id == $m->id && $l == $ent->weight){
						if($lk == $topLevel){
							$m->top = true;
						}
						$res[$m->id] = $m;
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
		$query = trim($query);
		$offset = Yii::app()->request->getParam('offset', 0, 'int');
		$user = Yii::app()->request->getParam('user', 0, 'int');
		$category = Yii::app()->request->getParam('category', 0, 'int');
		$region = Yii::app()->request->getParam('region', 0, 'int');
		//$cacheKey = $query . '|#|' . $offset . '|#|' . $user . 'eugen_was_here:)';
		//start to cache!!
		
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
			$html = $this->renderPartial('list', array(
				'model'=>$adverts,
				'users'=>$users,
				'aViews' => $aViews,
			), true, true);
			$tagsHtml = Widget::create('YamaTags', 'yamatags', array('query' => $query, 'limit' => 14))->html(true);
			echo CJSON::encode(array(
				'else' => $else, 
				'offset' => $offset, 
				'selector' => '.b-market__middle-i', 
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
	
	public function actionInfo(){
		Users::model();
		die;
		$criterea = new EMongoCriteria();
        $criterea->addCond('id', 'in', array('21921', '1'));
		$users = Mongo_Users::model();
		//$users->setMongoDBComponent(Yii::app()->socialmongo);
		$res = $users->findAll($criterea);
		d($res);
		die;
		Api_Subscribe::model()->debug = 1;
		$res = Api_Subscribe::model()->getUserSubscribe(Yii::app()->user->id, array('text' => 'samsung'));
		d($res);
		die;
		
	
		die;
		$ids = '21812,21802,21774,17857,21799,21793,21788,21785';
		$ids = explode(',', $ids);
		
		d(Mongo_Users::getUsers($ids));
		die;
		$criterea = new EMongoCriteria();
        $criterea->addCond('id', 'in', $ids);
		$users = Mongo_Userstest::model()->findAll($criterea);
		//d($users);
		//die;
		//$model = Catalog_Sections::model();
		//$model->debug = 1;

		//$model = $model->find('section_id = :id', array(':id' => 3210));
	}
}