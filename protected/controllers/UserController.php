<?php

class UserController extends Controller
{

    public $layout = 'user';
    public $title  = '';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }
	
	public function init(){
		$breadCrumbs = Widget::create('Breadcrumbs', 'Breadcrumbs');
		$bc = array(
				array('url' => Yii::app()->params['migomBaseUrl'], 'title' => Yii::t('Social','Главная')),
				array('url' => Yii::app()->params['socialBaseUrl'], 'title' =>  Yii::t('Social','Мои новости')),
		);
		$breadCrumbs->setBreadcrumbs($bc);
	}

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow readers only access to the view file
                'actions' => array('edit', 'deletenew', 'profile', 'uploadavatar'),
                'roles' => array('user', 'moderator', 'administrator')
            ),
            array('allow', // allow readers only access to the view file
                'actions' => array('index', 'createUserAvatar'),
                'users' => array('*')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $id = Yii::app()->request->getParam('id', Yii::app()->user->id);
        if (!$id) {
            $this->redirect('/site/login');
        }

        if ($id != Yii::app()->user->id) {
            $this->forward('profile');
        }
		
		$this->title = Yii::t('Social', 'Мои новости | Migom.by');
        $model    = $this->loadModel($id);
		
        $criterea = new EMongoCriteria();
        $criterea->addCond('user_id', '==', Yii::app()->user->id);
        $news     = News::model()->find($criterea);
		$saveFlag = false;
		if ($news && is_array($news->entities)) {
            foreach ($news->entities as $key => $en) {
				if($en->deleted == 1){
					unset($news->entities[$key]);
					$saveFlag = true;
				}
            }
        }
		
		if($saveFlag == true){
			$news->save();
		}
		
        $this->render('index', array('model' => $model, 'news'  => $news));
    }

    public function actionProfile()
    {
		Header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); //Дата в прошлом 
		Header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); // HTTP/1.1 
		Header("Pragma: no-cache"); // HTTP/1.1
		Header("Last-Modified: ".gmdate("D, d M Y H:i:s")."GMT");
        $id    = Yii::app()->request->getParam('id', Yii::app()->user->id);
        $model = Users::model()->findByPk($id);
        if(!$model){
            throw new CHttpException(404, Yii::t('Site', 'Upps! Такой страницы нету'));
        }
		Widget::get('Breadcrumbs')->addBreadcrumbs(array('url' => '#', 'title' => Yii::t('Social', 'Профиль: :user_name', array(':user_name' => $model->login))));
        $this->title = Yii::t('Social', 'Профиль {login} | Migom.by', array('{login}' => $model->login));
        $this->render('profile', array('model' => $model));
    }

    public function actionEdit()
    {
        Header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); //Дата в прошлом 
		Header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); // HTTP/1.1 
		Header("Pragma: no-cache"); // HTTP/1.1 
		Header("Last-Modified: ".gmdate("D, d M Y H:i:s")."GMT");
		Widget::get('Breadcrumbs')->addBreadcrumbs(array('url' => '#', 'title' => Yii::t('Social', 'Редактирование профиля')));
        if (Yii::app()->user->getIsGuest()) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        $id    = Yii::app()->user->id;
        $model = $this->loadModel($id);
        $model->setScenario('general_update');

        if (Yii::app()->getRequest()->isAjaxRequest) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $redirect = false;
        $success  = true;
		
		$criteria = new EMongoCriteria();
		$criteria->addCond('user_id', 'equals', Yii::app()->user->id);
		$news     = News::model()->find($criteria);
		
        if (isset($_POST['Users_Profile'])) 
		{
			
			$notifyParams = array('comments_activity', 'all_activity');
			foreach($notifyParams as $notifyParam){
				if(Yii::app()->request->getParam($notifyParam)){
					$news->disable_notify[$notifyParam] = $notifyParam;
				} else {
					unset($news->disable_notify[$notifyParam]);
				}
			}
			$news->save();
		
            if(file_exists($model->getAvatarPath(true))){
                if(copy($model->getAvatarPath(true), $model->getAvatarPath())){
                    UserService::clearTempAvatars($model->id);
                }
            }
            if ($_POST['birthday'] && $_POST['birthday']['year'] && $_POST['birthday']['month'] && $_POST['birthday']['day']) {
                $model->profile->birthday = $_POST['birthday']['year'] . '-' . $_POST['birthday']['month'] . '-' . $_POST['birthday']['day'];
            } else {
                $model->profile->birthday = null;
            }

            $model->profile->setScenario('update');
            $model->profile->attributes = $_POST['Users_Profile'];
            $model->profile->validate();
            if ($model->profile->validate() && $model->profile->save()) {
                $redirect = true;
            } else {
                $redirect = false;
                $success  = false;
            }
        } else {
			UserService::clearTempAvatars($model->id);
		}

        if (isset($_POST['Users'])) {
            $model->setScenario('general_update');
            $model->attributes = $_POST['Users'];
            if ($model->validate() && $model->save() && $success) {
                $redirect = true;
            } else {
                $redirect = false;
            }
        }

        if ($redirect) {
            $this->redirect('/user/index');
        }

        $days = array(
            '0'    => Yii::t('Profile', 'дд'),
        );
        $month = array(
            '0'   => Yii::t('Profile', 'мм'),
            '01'  => Yii::t('Profile', 'январь'),
            '02'  => Yii::t('Profile', 'февраль'),
            '03'  => Yii::t('Profile', 'март'),
            '04'  => Yii::t('Profile', 'апрель'),
            '05'  => Yii::t('Profile', 'май'),
            '06'  => Yii::t('Profile', 'июнь'),
            '07'  => Yii::t('Profile', 'июль'),
            '08'  => Yii::t('Profile', 'август'),
            '09'  => Yii::t('Profile', 'сентябрь'),
            '10'  => Yii::t('Profile', 'октябрь'),
            '11'  => Yii::t('Profile', 'ноябрь'),
            '12'  => Yii::t('Profile', 'декабрь'),
        );
        $year = array(
            '0' => Yii::t('Profile', 'гггг')
        );
        for ($i = date('Y') - 100; $i < date('Y') - 14; $i++) {
            $year[$i] = $i;
        }
        for ($i = 1; $i < 32; $i++) {
            $days[$i] = $i;
        }

        $this->title = Yii::t('Social', 'Редактировать профиль {login} | Migom.by', array('{login}' => $model->login));

        $regions = Regions::model()->findAll('parent_id = 1 OR to_menu = 1 OR id = :city ORDER BY to_menu DESC', array(':city' => $model->profile->city_id));

        $this->render('profile/edit', array('model' => $model, 'regions' => $regions, 'month' => $month, 'year'  => $year, 'days'  => $days, 'news' => $news));
    }

    public function actionUploadAvatar(){
        Yii::import("core.extensions.EAjaxUpload.qqFileUploader");
        $model = $this->loadModel(Yii::app()->user->id);
        $path = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..';
        $folder = $path . Users::AVATAR_PATH . DIRECTORY_SEPARATOR . $model->id;
        $allowedExtensions = array("jpg","jpeg","png"); //array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 2 *1024 * 1024; // maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $uploader->setName('avatar');
        $oldUmask = umask ();
        umask ( 0 );
        $res = @mkdir ( $folder, 0777 );
        umask ( $oldUmask );
        $oldUmask = umask ();
        $result = $uploader->handleUpload($folder, true);
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        $fileSize=filesize($folder.$result['filename']); //GETTING FILE SIZE
        if(isset($result['filename'])){
            $fileName = 'avatar-temp.jpg';
        }
        $fileName = 'error';
        // TODO::резайзить файл сразу после загрузки
        UserService::uploadAvatar($model->id, $folder.$result['filename'], 'avatar-temp');

        echo $return;// it's array
        Yii::app()->end();
    }

    public function loadModel($id)
    {
        $model = Users::model()->findByPk($id);
        if ($model === null){
			Yii::app()->user->logout();
			throw new CHttpException(404, 'The requested page does not exist.');
		}
        return $model;
    }

    public function actionCreateUserAvatar($id, $x = null, $y = null, $tempFlag = false)
    {
		Header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); //Дата в прошлом 
		Header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1 
		Header("Pragma: no-cache"); // HTTP/1.1 
		Header("Last-Modified: ".gmdate("D, d M Y H:i:s")."GMT");
        $user = Users::model()->findByPk($id);
		if(!$user){
			$user = new Users();
			$user->id = 0;
		}
        $file = Yii::app()->basePath . '/../images/users/' . $user->id . '/avatar.jpg';
        $fileTemp = Yii::app()->basePath . '/../images/users/' . $user->id . '/avatar-temp.jpg';
        if (!file_exists($file) && $user) {
            $srcImage = UserService::uploadAvatarFromEmail($user->id, $user->email);
            $file     = Yii::app()->basePath . '/..' . $srcImage;
            $image    = Yii::app()->image->load($file);
        }
        if($user && $x && $y && file_exists($file)){
            if(file_exists($fileTemp) && $tempFlag){
                $res = UserService::cropAvatar($user->id, $fileTemp, $x, $y, 'avatar-temp');
            } else {
                $res = UserService::cropAvatar($user->id, $file, $x, $y);
            }

            if($res['success']){
				$image = $res['image'];
				if(!$tempFlag){
					$image->save($res['file']);
					$image = Yii::app()->image->load($res['file']);
				}
            }
        }
        if(isset($image)){
            $image->render();
        }else {
            return false;
        }
    }

}
