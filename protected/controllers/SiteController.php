<?php

class SiteController extends Controller {

	public $layout = 'yama';
	public $title = 'Яма - бесплантые объявления';
	public $description = 'Яма - бесплантые объявления. Подать объяление на доске частных объявлений бесплатно.';
	public $keywords = 'бесплантые объявления,подать,доска,частные,минск,беларусь,отдам даром,сайт,дать,подать';

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
	
	protected function _prepareData($text, $limit = 10, $offset = 0){
		if(!$entities = Tags::model()->getSearch(array('text' => $text, 'entity_type_id' => 4))){
			return array();
		}
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
		$model = Adverts::model()->findAll(array('condition' => "id IN ({$sIds}) AND status = 1", 'order' => 'last_up DESC', 'limit' => $limit, 'offset' => $offset));
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
		
		if($query){
			$this->description = $query;
			$adverts = $this->_prepareData($query, Adverts::LIMIT + 1, $offset);
		} elseif(!$user) {
			$adverts = Adverts::model()->findAll(
				array(
					'condition' => 'status = 1',
					'order' => 'last_up DESC',
					'limit' => Adverts::LIMIT + 1,
					'offset' => $offset,
				));
		} else {
			$adverts = Adverts::model()->findAll(
				array(
					'condition' => 'status = 1 AND user_id = :uId',
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
		$categories = array();
		$uids = array();
		$catIds = array();
		foreach($adverts as $adv){
			$uids[] = $adv->user_id;
			$catIds[] = $adv->category;
		}
		array_unique($catIds);
		if(count($catIds) && !$query){
			$categories = Categories::model()->findAll('id != 0 AND id in ('.implode(',', $catIds).')');
		}
		
		$users = Mongo_Users::getUsers($uids);

		if(Yii::app()->request->isAjaxRequest){
			$html = $this->renderPartial('list', array(
				'model'=>$adverts,
				'users'=>$users,
			), true, true);
			echo CJSON::encode(array('else' => $else, 'offset' => $offset, 'selector' => '.b-market__middle-i', 'title' => $this->title, 'html' => $html));
			Yii::app()->end();
		}
		$this->render('index', array(
			'model'=>$adverts,
			'query'=>$query,
			'users'=>$users,
			'else' => $else,
			'offset' => $offset,
			'categories' => $categories,
		));
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