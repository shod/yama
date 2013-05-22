<?php

class AhimsaController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='yama';
	public $title='Yama.Migom.by';
	public $description='Сайт бесплатных объявлений';
	public $keywords = '';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = Adverts::model()->findByPk($id);
		
		if(!$model){
			throw new CHttpException(404, 'Страница не найдена');
		}
		
		$criterea = new EMongoCriteria();
        $criterea->addCond('id', '==', $model->id);
		$views = Mongo_Views::model()->find($criterea);
		if(!$views){
			$views = new Mongo_Views();
			$views->count = 1;
			$views->id = $model->id;
		} else {
			$views->count++;
		}
		$views->last_time = time();
		$views->save();
		
		$comments = Widget::create('WComments', 'wcomments', 
			array(
				'entity' => 'adverts',
				'id' => $model->id,
				'title' => ''
			))->html(true);
		
		$cache_key = 'ahimsa_' . $model->id;
		if(Yii::app()->request->isAjaxRequest){
			$cache_key .= '_ajax';
		}
		if(Yii::app()->user->id == $model->id){
			$cache_key .= '_my';
		}
		
		$html = false;//Yii::app()->fileCache->get($cache_key);
		if(!$html){
		
			$imageDir = Yii::app()->getBasePath() . '/..' . Adverts::IMAGE_PATH . '/' . $id . '/';
			$images = FileServices::getImagesFromDir($imageDir);
			$auction = Auction::model()->findAll('advert_id = :id', array(':id' => $id));
			
			$this->title = mb_substr($model->description, 0, 230);
			$this->description = mb_substr($model->text, 0, 480);
			
			$auctFlag = true;
			$uids = array();
			
			foreach($auction as $auct){
				$uids[$auct->user_id] = $auct->user_id;
				if($auct->user_id == Yii::app()->user->id){
					$auctFlag = false;
				}
			}
			$uids[$model->user_id] = $model->user_id;
			$users = Mongo_Users::getUsers($uids);
			
			$viewParams = array(
				'model'=>$model,
				'images'=>$images,
				'users'=>$users,
				'auction' => $auction,
				'auctFlag' => $auctFlag,
			);
		}
		if(Yii::app()->getRequest()->isAjaxRequest){
			if(!$html){
				$viewParams['popup'] = true;
				$html = $this->renderPartial('view',$viewParams, true, false);
				Yii::app()->fileCache->set($cache_key, $html, '', new CDbCacheDependency('select updated_at from adverts where id = ' . $model->id));
			}
			$html = str_replace('{{#comments}}', $comments, $html);
			echo CJSON::encode(array('selector' => '#itemWindow .content', 'title' => $this->title, 'description' => $this->description, 'html' => $html));
			Yii::app()->end();
		}
		
		if(!$html){
			$viewParams['popup'] = false;
			$html = $this->render('view',$viewParams, true, true);
			Yii::app()->fileCache->set($cache_key, $html, '', new CDbCacheDependency('select updated_at from adverts where id = ' . $model->id));
		}
		
		$html = str_replace('{{#comments}}', $comments, $html);
		echo $html;
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->title = Yii::t('Yama', 'Создать объявление');
		if(Yii::app()->user->isGuest){
			Yii::app()->user->returnUrl = Yii::app()->getBaseUrl(true) . $this->createUrl('/ahimsa/create');
			$this->redirect(Yii::app()->params['socialBaseUrl'] . '/login');
		}

		$model=new Adverts_Temp('new');
		$model->user_id = Yii::app()->user->id;
		
		if($_POST && isset($_POST['Adverts_Temp'])){
			$model->phone = $_POST['phone_prefix'] . $_POST['Adverts_Temp']['phone_postfix'];
			$model->free = $_POST['Adverts_Temp']['free'];
		}

		if (Yii::app()->getRequest()->isAjaxRequest) {
			$model->scenario = 'create';
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
		
		$infoProd = Info_Products::model();
		if($model->product_id){
			$criterea = new EMongoCriteria();
			$criterea->product_id('==', $model->product_id);
			$infoProd = Info_Products::model()->find($criterea);
			if(!$infoProd){
				$api = Api_Product::model();
				$apiRes = (array) $api->getInfo('attr', array('id' => array($model->product_id), 'list' => array('title', 'url', 'image', 'cost', 'id', 'section'), 'image_size' => 'small'));
				if($arp = array_pop($apiRes)){
					$infoProd->product_id = $arp->id;
					$infoProd->section_id = $arp->section;
					$infoProd->name = $arp->title;
					$infoProd->save();
				}
			}
		}
		

		if(isset($_POST['Adverts_Temp'])){
			$model = Adverts_Temp::model()->findByPk($_POST['Adverts_Temp']['id']);
			if(!$model || $model->user_id != Yii::app()->user->id){
				throw new CHttpException(404, Yii::t('Site', 'Ошибка'));
			}

			$model->attributes = $_POST['Adverts_Temp'];
			$model->phone = $_POST['phone_prefix'] . $_POST['Adverts_Temp']['phone_postfix'];
			$model->free = $_POST['Adverts_Temp']['free'];

			if($model->validate()){
				$publicModel = new Adverts('clone');
				$publicModel->attributes = $model->attributes;
				$publicModel->free = $model->free;
				
				if($publicModel->save()){
					$tags = Tags::model();
					$textToTags = $publicModel->text . ' ' . $publicModel->description;
					$textToTags = $textToTags . ' ' . Regions::model()->findByPk($publicModel->region)->title;
					$textToTags = $textToTags . ' ' . Categories::model()->findByPk($publicModel->category)->title;
					$tags->postProductLink(array('text' => $textToTags, 'entity_type_id' => 4, 'entity_id' => $publicModel->id));
				}
				$this->redirect('/');
			}
		}

		$model->save();
		
		$regions = Regions::model()->findAll('parent_id = 1 OR to_menu = 1 ORDER BY to_menu DESC');

		$this->render('create',array(
			'model'=>$model,
			'infoProd' => $infoProd,
			'regions' => $regions,
		));
	}
	
	public function actionRegions(){
        if(Yii::app()->user->getIsGuest()) return false;

        $regions = Regions::model()->findAll('parent_id = :parent_id', array(':parent_id' => Yii::app()->request->getParam('parent_id')));
        if(count($regions)){
            $this->renderPartial('regions', array('regions' => $regions, 'name' => Yii::app()->request->getParam('name')));
        }
    }

	public function actionUpdate($id)
	{
		$this->title = Yii::t('Yama', 'Редактировать объявление');
		$model=$this->loadModel($id);
		if($model->user_id != Yii::app()->user->id){
			throw new CHttpException(403, Yii::t('Site', 'Ошибка'));
		}
		
		$imageDir = Yii::app()->getBasePath() . '/..' . Adverts::IMAGE_PATH . '/' . $id . '/';
		$images = FileServices::getImagesFromDir($imageDir);
		
		if($k = in_array($model->image, $images)){
			unset($images[$k-1]);
		}
		sort($images);
		
		$infoProd = Info_Products::model();
		if($model->product_id){
			$criterea = new EMongoCriteria();
			$criterea->product_id('==', $model->product_id);
			$infoProd = Info_Products::model()->find($criterea);
			if(!$infoProd){
				$api = Api_Product::model();
				$apiRes = (array) $api->getInfo('attr', array('id' => array($model->product_id), 'list' => array('title', 'url', 'image', 'cost', 'id', 'section'), 'image_size' => 'small'));
				if($arp = array_pop($apiRes)){
					$infoProd = new Info_Products();
					$infoProd->product_id = $arp->id;
					$infoProd->section_id = $arp->section;
					$infoProd->name = $arp->title;
					$infoProd->cost = $arp->cost;
					$infoProd->save();
				}
			}
		}

		if($_POST && isset($_POST['Adverts'])){
			$model->phone = $_POST['phone_prefix'] . $_POST['Adverts']['phone_postfix'];
			$model->free = $_POST['Adverts']['free'];
		}
		
		if (Yii::app()->getRequest()->isAjaxRequest) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

		if(isset($_POST['Adverts']))
		{
			$model->attributes=$_POST['Adverts'];
			$model->phone = $_POST['phone_prefix'] . $_POST['Adverts']['phone_postfix'];
			$model->free = $_POST['Adverts']['free'];
			if($model->save()){
				$tags = Tags::model();
				$textToTags = $model->text . ' ' . $model->description;
				$textToTags = $textToTags . ' ' . Regions::model()->findByPk($model->region)->title;
				$textToTags .= ' ' . Categories::model()->findByPk($model->category)->title;
				$tags->postProductLink(array('text' => $textToTags, 'entity_type_id' => 4, 'entity_id' => $model->id));
				$this->redirect('/');
			}
		}
		
		$regions = Regions::model()->findAll('parent_id = 1 OR to_menu = 1 OR id = :city ORDER BY to_menu DESC', array(':city' => $model->region));

		$this->render('update',array(
			'model'		=> $model,
			'infoProd'	=> $infoProd,
			'images' => $images,
			'regions' => $regions,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Adverts');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionUploadImage($id)
	{
        Yii::import("core.extensions.EAjaxUpload.qqFileUploader");
        $path = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..';
        $folder = $path . Adverts::IMAGE_PATH . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR;
		FileServices::createDirectory($folder);

        $allowedExtensions = array("jpg","jpeg");//array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit =  2 * 1024 * 1024;// maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->translitName()->handleUpload($folder, true);
		if(isset($result['success'])){
			$image = Yii::app()->image->load($folder.$result['filename']);
			$image->resize(Adverts::$size['min']['x'], Adverts::$size['min']['y'], Image::NO_MORE)->quality(100);
			$destanation = $folder;
			FileServices::createDirectory($destanation);
			$image->save($destanation . $result['filename']);
			$result['fullname'] = Yii::app()->getBaseUrl(true) . Adverts::IMAGE_PATH . '/' . $id . '/mini/' . $result['filename'];
		}
		
        $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        echo $result;// it's array
		
        Yii::app()->end();
    }
	
	public function actionGetImage($id, $image, $type)
    {
		Header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); //Дата в прошлом 
		Header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1 
		Header("Pragma: no-cache"); // HTTP/1.1 
		Header("Last-Modified: ".gmdate("D, d M Y H:i:s")."GMT");
		
        $file = Yii::app()->basePath . '/..' . Adverts::IMAGE_PATH . '/' . $id . '/' . $image;
		if(!file_exists($file)){
			return false;
		}
		if(!isset(Adverts::$publicSizeTypes[$type])){
			return false;
		}
		
		$destanation = Yii::app()->basePath . '/..' . Adverts::IMAGE_PATH . '/' . $id . '/' . $type . '/';
		
		$img = Yii::app()->image->load($file);
		$resizeType = Image::MAX;
		if($type == 'view'){
			$resizeType = Image::NO_MORE;
		}
		$img->resize(Adverts::$publicSizeTypes[$type]['x'], Adverts::$publicSizeTypes[$type]['y'], $resizeType);
		if(Adverts::$publicSizeTypes[$type]['op'] == 'crop'){
				$img->crop(Adverts::$publicSizeTypes[$type]['x'], Adverts::$publicSizeTypes[$type]['y']);
		}
		//$img->addWatermark('YAMA.MIGOM.BY');
		$img->quality(100);
		FileServices::createDirectory($destanation);
		$img->save($destanation . $image);
		$img = Yii::app()->image->load($destanation . $image);
        if(isset($img)){
            $img->render();
        }else {
            return false;
        }
    }
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Adverts('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Adverts']))
			$model->attributes=$_GET['Adverts'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Adverts::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='adverts-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionGetProduct($url)
	{
		$product_id = $url;
		if(!is_numeric($url)){
			$url = trim($url);
			$url = trim($url, '/');
			preg_match('#[\d]+$#', $url, $product_id);
			$product_id = array_pop($product_id);
		}

		$api = Api_Product::model();
		$apiRes = $api->getInfo('attr', array('id' => array($product_id), 'list' => array('title', 'url', 'image', 'cost', 'id', 'section'), 'image_size' => 'small'));
		if($apiRes){
			$res = (array) $apiRes;
			$res = array_pop($res);
			$res = (array) $res;
			$res['success'] = true;
			echo CJSON::encode($res);
			Yii::app()->end();
		}
		$res['success'] = false;
		echo CJSON::encode((array) $res);
	}
	
	public function actionAuction(){
		if(!Yii::app()->getRequest()->isAjaxRequest){
			return false;
		}
		$res = array('success' => false);

		$id = Yii::app()->request->getParam('id', 0, 'int');
		$price = Yii::app()->request->getParam('price', 0, 'int');
		if(!$id || !$price){
			echo CJSON::encode($res);
		}
		$auc = Auction::model()->find('advert_id = :id AND user_id = :user_id', array(':id' => $id, ':user_id' => Yii::app()->user->id));
		$advert = Adverts::model()->findByPk($id);
		
		if($auc){
			$auc->delete();
		}
		$auction = new Auction();
		$auction->price = $price;
		$auction->advert_id = $id;
		$auction->user_id = Yii::app()->user->id;

		if($auction->save()){
			$auctions = Auction::model()->findAll('advert_id = :id', array(':id' => $id));
			foreach($auctions as $auct){
				$uids[$auct->user_id] = $auct->user_id;
			}
			
			$users = Mongo_Users::getUsers($uids);
			$res = array('success' => true, 'content' => $this->renderPartial('auctionPost', array('auctions' => $auctions, 'users' => $users), true, true));
		}

		echo CJSON::encode($res);
		
		if($res['success']){
			$notify = Api_AuctionNotify::model();
			$notify->postNew(array(
				'advert' => $advert->attributes,
				'auction' => $auction->attributes,
			));
		}
		Yii::app()->end();
	}
	
	public function actionUp($id){
		$id = Yii::app()->request->getParam('id', 0, 'int');
		$adv = Adverts::model()->findByPk($id);
		$res = array('success' => false);
		if($adv->user_id == Yii::app()->user->id && $adv->last_up < time() - 3600*24){
			$adv->last_up = time();
			$adv->save();
			$res['success'] = true;
		}
		echo CJSON::encode($res);
		Yii::app()->end();
	}
	
	public function actionChangeStatus($id){
		$id = Yii::app()->request->getParam('id', 0, 'int');
		$status = Yii::app()->request->getParam('status', 1, 'list', array(1,2));
		$adv = Adverts::model()->findByPk($id);
		$adv->scenario = 'specialUpdate';
		$res = array('success' => false);
		if($adv->user_id == Yii::app()->user->id){
			$adv->status = $status;
			$adv->save();
			$tags = Tags::model();
			$tags->postDeleteProductLink(array('entity_id' => $id, 'entity_type_id' => 4));
			$res['success'] = true;
		}
		echo CJSON::encode($res);
		Yii::app()->end();
	}
	
	public function actionMarks($id){ // for next build
		$data = Yii::app()->session->get('yama');

        $advert = Adverts::model()->findByPk($id);

        $add_advert = array(
            'image' => Yii::app()->getBaseUrl(true) . '/images/ahimsa/' . $advert->id . '/mini/' . $advert->image,
            'productUrl'=> $whirl->parms->create_url(array("info" => $pid)),
            'title' => $obj->get_name(),
            'price' => $cost["min_cost_us"],
        );

        $data[$pid] = $add_advert;
        Yii::app()->session->add('compare',$data);

        if(!(Yii::app()->user->isGuest)) {
            $code = array('type' => 'compare','data' =>$data, 'user_id' => Yii::app()->user->id);
            Sys_Job::model()->replace('soc_sync_data', Yii::app()->user->id, $code, time());
        }
	}
	
	public function actionDellImage(){
		if(Yii::app()->user->isGuest && !Yii::app()->request->isAjaxRequest){
			return false;
		}
		$id = Yii::app()->request->getParam('id', 0, 'int');
		$url = Yii::app()->request->getParam('url', 0, 'string');
		$model = Adverts::model()->findByPk($id);
		if(Yii::app()->user->id != $model->user_id){
			return false;
		}
		$file = array_pop(explode('/', $url));
		
		$dir = Yii::app()->getBasePath(true) . '/..' . Adverts::IMAGE_PATH . '/' . $model->id . '/';
		@unlink($dir . $file);
		foreach(Adverts::$publicSizeTypes as $type => $val){
			@unlink($dir . $type . '/' . $file);
		}
		if($model->image == $file){
			$imageDir = Yii::app()->getBasePath() . '/..' . Adverts::IMAGE_PATH . '/' . $id . '/';
			$images = FileServices::getImagesFromDir($imageDir);
			$model->scenario = 'specialUpdate';
			if(!count($images)){
				$model->image = '';
			} else {
				$model->image = array_shift($images);
			}
			$model->save();
		}
		return true;
	}
}
