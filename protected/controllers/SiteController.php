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
                'actions' => array('index', 'error', 'search', 'subscribe', 'info', 'testnewsearch'),
                'users' => array('*')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }
	
	protected function _OLD_prepareData($text, $limit = 10, $offset = 0, $region = 0, $category = 0){
		if(!$entities = Tags::model()->getSearch(array('text' => $text, 'entity_type_id' => 4, 'user' => Yii::app()->user->id))){
			return array();
		}
		
		/*if(Yii::app()->request->getParam('debug', 0)){
			d($entities);
		}*/
		
		
		$topLevel = count(explode(' ', $text));
		
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
						if($topLevel <= $l){
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
		$tags = array();
		
		if($region){
			$region = Regions::model()->findByPk($region);
		}
		
		if($category){
			$category = Categories::model()->findByPk($category);
		}
	
		if($query){
			//$dependency = new CDbCacheDependency('SELECT last_up FROM adverts order by last_up desc limit 1');
			$this->description = $query;
			$data = $this->_prepareData($query, Adverts::LIMIT + 1, $offset, $region, $category);
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
	
	public function _prepareData($strSearch, $limit = 10, $offset = 0, $region = 0, $category = 0){
	
		$ids = array();
		$full = array();
		$all = array();
		
		$strSearch = trim($strSearch);
		$strSearch = strip_tags($strSearch);
		$strSearch = mb_ereg_replace('[\W]', ' ', $strSearch);
		$strSearch2 = implode(' | ', explode(' ', $strSearch));
		 
		$cl = Yii::App()->sphinx;
		$cl->SetConnectTimeout(1);
		$cl->SetWeights(array(100, 1));
		//$cl->SetMatchMode($MatchMode);
		
		$cl->SetLimits($offset = 0, $limit = 1000, $max_matches = 1000, $cutoff = 0);
		$cl->SetRankingMode(SPH_RANK_PROXIMITY_BM25);
		$cl->SetSortMode(SPH_SORT_RELEVANCE);
		
		$cl->SetArrayResult(true);
		
		$cl->AddQuery("{$strSearch}", "index_ahimsa");
		$cl->AddQuery("{$strSearch2}", "index_ahimsa");
		
		$res = $cl->RunQueries();
		
		if(is_array($res)){
			if(isset($res[0]['matches'])){
				foreach($res[0]['matches'] as $m){
					$full[$m['id']] = array('id' => $m['id'], 'weight' => $m['weight']);
					$ids[$m['id']] = $m['id'];
				}
			}
			if(isset($res[1]['matches'])){
				foreach($res[1]['matches'] as $m){
					$all[$m['id']] = array('id' => $m['id'], 'weight' => $m['weight']);
					$ids[$m['id']] = $m['id'];
				}
			}
		}
		$all = array_diff_key($all, $full);
		
		$tags = Tags::model()->getTagsByEntities(array('entities' => $ids, 'entity_type_id' => 4, 'limit' => 10, 'text' => $strSearch));
		
		$levels = array();
		foreach($all as $ent){
			$levels[$ent['weight']] = $ent['weight'];
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
			array('condition' => $condition, 'order' => 'last_up DESC', 'limit' => $limit, 'offset' => $offset)
		);
		$res = array();
		krsort($levels);
		
		foreach($full as $f){
			foreach($model as $m){
				if($m->id == $f['id']){
					$m->top = true;
					$res[$m->id] = $m;
				}
			}
		}
		
		foreach($levels as $l){
			foreach($model as $k => $m){
				foreach($all as $ent){
					if($ent['id'] == $m->id && $ent['weight'] == $l){
						$res[$m->id] = $m;
						unset($model[$k]);
					}
				}
			}
		}
		return array('res' => $res, 'tags' => $tags);
	}
}