<?php

class CommentsController extends Controller {

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
                'actions' => array('postadd', 'getcount'),
                'users' => array('*')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }


    public function actionGetCount() {
        $model = Comments::model();
        $data = $model->getEntityCount($_GET['entity'],array('id'=>$_GET['id'], 'user_id' => Yii::app()->user->id));
        $res = array();
        foreach ($data->content->comments as $comment) {
            $res[$comment->id] = $comment->count;
        }
        $this->render(Yii::app()->request->getParam('type'), $res);
    }

    public function actionGetData() {
        return Comment::findAllByCode($_GET['code']);
    }

    private function _get_data($owner_data, $owner_id = 0, $level = 0, &$output) {
        foreach ((array) $owner_data[$owner_id] as $obj) {
            $obj->level = $level;
            $output[] = $obj;
            if (isset($owner_data[$obj->id]))
                $this->_get_data($owner_data, $obj->id, $level + 1, &$output);
        }
    }


    public function actionPostAdd() {

        $entity = Yii::app()->request->getParam('entity', 'news');
        $userId = Yii::app()->user->id;
		//d($_POST);
        $params = array(
            'entity_id' => $_POST['entity_id'],
            'text' => $this->_tagsReplace($this->moderString(trim($_POST['text']))),
            'parent_id' => (isset($_POST['parent_id']) && $_POST['parent_id'] > 0) ? $_POST['parent_id'] : 0,
            'user_id' => $userId,
        );
		
		Yii::app()->cache->delete('entityCommentCount' . $entity . $_POST['entity_id']); //сброс счетчиков количества комментариев
		
		Widget::create('WComments', 'wcomments', array('entity' => $entity, 'id' => $_POST['entity_id']))->deleteCache();

		$model = Comments::model();
		//$model->debug = 1;
		$return = $model->postEntity($entity, $params);
	    $owner_data = array();
		$data = array();

		if(isset($return->comment)){
			$obj = $return->comment;
			
			$obj->user = (object)array('login' => Yii::app()->user->name);
			if(!isset($owner_data[$obj->parent_id][$obj->id])){
				$owner_data[$obj->parent_id][$obj->id] = $obj;
			}
			if(count($owner_data)){
				$data = ComentsService::getDataTree($owner_data, $obj->parent_id);
			}
			
			$size = 50;
			if($obj->parent_id > 0){
				$size = 30;
			}
			
			$this->renderPartial('core.widgets.views.comments._item', array('data' => $data, 'avatar_size' => array('x' => $size, 'y' => $size), 'level' => 0, 'parent_id' => $obj->parent_id));
			
		}
    }

    public function actionPostUpdate() {
        if (Yii::app()->user->check()) {
            if ($id = $_POST['id']) {
                $comment = Comment::factoryByIdCode($id);
            } else {
                $comment = Comment::factory($_POST['code']);
            }
            $comment->text = $_POST['text'];
            $comment->rejected = $_POST['rejected'];

            return $comment->save();
        }
    }

	private function _tagsReplace($str) {
		$str = str_replace('[b]','<b>',$str);
		$str = str_replace('[/b]','</b>',$str);
		$str = str_replace('[i]','<i>',$str);
		$str = str_replace('[/i]','</i>',$str);
		$str = str_replace('[quote]','&laquo;',$str);
		$str = str_replace('[/quote]','&raquo;',$str);
		$str = str_replace('[/url]','</a>',$str);
		
		if(strpos($str, '[url=') !== false) {
			preg_match_all("/\[url=+([а-яА-Яa-zA-Z0-9\-_\.\/:\?=\]\[\&]+)\]+/", $str,$arr_block);
			foreach($arr_block[1] as $ar) {
				$str = str_replace('[url='.$ar.']','<a target="_blank" href="'.Yii::app()->params->migomBaseUrl.'/proxy.php?link='.$ar.'">',$str);
			}
		}
		
		return $str;
	}
	
    public function moderString($str) {
        $stop_worlds = array("хуй", "хуй", " хуй", "xyй", " xyя", "хуя", " хуе", " хую", "xyе", "xyю", "pizda", "pidor", "pidar", "сукин", " бля", "говно", "ебался", "ебало", "ебалово", "ебло", "уебак", "уёбак", "ебака", "уебашивать", "уебенить",
            "уебище", "ёбанный", "ёбаный", "придурок", "долбаёб", "долбаеб", "ебля", "ебли", "ебаный", "ёбаный", "ёбарь", "мозгоёб", "разъебай", "разьебай", "ёбина", "ебина", "взъебка", "взъёбка", "ёбля", "ебля",
            "ебаный", "ёбнуть", "ебануть", "ебистика", "поебень", "ебанн", "срака", "всраться", "хуёв", "xyёв", "писец", "подъеб", "подъебка", "подъёбка", "мудак", "дибил", "дебил", "поебистика",
            "гандон", "гондон", "мать вашу", "недоносок", "жопа", "сучка", "блядва", "пёздный", "пездный", "ебашить", "говноеб", "шлюха", "ебарь", "педераст", "еблан", "ублюдок", "мудило", "хуеть", "блябудунах", "ебанат",
            "суки", "сука", "пидар", "ебу", "еби", "уеб", "бляд", "ебись", "заеб", "трах", "еб вашу мать", "еб вашу мать", "ебать", "ебаль", "пидор", "ебёт", "ебнуть", "упырь", "урод");

        foreach ($stop_worlds as $ar) {
            if (stristr($str, $ar) !== false) {
                $str = str_replace($ar, '...', $str);
            }
        }
        return $str;
    }

}