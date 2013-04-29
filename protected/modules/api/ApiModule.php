<?php

/**
 * @ignore
 */
class ApiModule extends CWebModule {

    public $keys;
    private $urlManager = array(
        'GET' => array(
            'api' => 'default/index',
            'api/auth/login/<key:\w+>' => 'api/auth/getLogin',
			'api/<controller:\w+>/<_a:(find)>' => 'api/<controller>/<_a>',
            'api/<controller:\w+>/<_a:(find|findAll)bypk>/<id>' => 'api/<controller>/<_a>',
			
			'api/<controller:\w+>/<action:\w+>/<id:\d+>' => 'api/<controller>/get<action>',
            'api/<controller:\w+>/<action:\w+>/<entity:\w+>/<id:\d+>' => 'api/<controller>/get<action>',
            'api/<controller:\w+>/<action:\w+>/<entity:\w+>' => 'api/<controller>/get<action>',
            
            'api/<controller:\w+>/<_a:(list)>' => 'api/<controller>/get<_a>',
        ),
        'POST' => array(
            'api/likes/<_a:(dislike|Like)>/<entity:\w+>' => 'api/likes/post<_a>',
            'api/<controller:\w+>/<_a:(update|insert|delite)>' => 'api/<controller>/<_a>', //static
            'api/<controller:\w+>/<action:\w+>/<id:\d+>' => 'api/<controller>/post<action>',
            'api/<controller:\w+>/<action:\w+>/<entity:\w+>' => 'api/<controller>/post<action>',
            'api/<controller:\w+>/<action:\w+>' => 'api/<controller>/post<action>',
        ),
//        'PUT' => array(
//            'api/<controller:\w+>/<_a:(update)>/<key:\w+>' => 'api/<controller>/put<_a>',
//        ),
//        'DELETE' => array(
//            'api/<controller:\w+>/<action:\w+>/<puid:\w+>' => 'api/<controller>/delete<action>',
//        ),
    );

    /**
     * this method is called when the module is being created
     * you may place code here to customize the module or the application
     *  import the module-level models and components
     */
    public function init() {
//        var_dump($_SERVER["REDIRECT_URL"], $_SERVER["REQUEST_METHOD"]);
//        var_dump($_POST);
//        $this->setImport(array(
//            'api.models.*',
//            'api.components.*',
//        ));
        $this->setComponents(array(
                                'render'=>array('class'=>'ERestRender'),
            ), true);
        Yii::app()->urlManager->addRules($this->urlManager[CHttpRequest::getRequestType()], false);

        Yii::app()->getErrorHandler()->errorAction = 'api/auth/pageNotFound';
    }

        public function beforeControllerAction($controller, $action) {
        $className = get_class($controller);
        if ($className != 'AuthController') {
            if (!$this->isAuth()) {
                return false;
            }
        }
        //dd($className);
        //dd($action);
        //die('------');
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
			//die("it is good");
            return true;
        }
        else
            return false;
    }

    private function isAuth() {
        $key = Yii::app()->getRequest()->getParam('key');
        if (!$key) {
            return true;
        }
        $cache = Yii::app()->cache->get($key);
        if ($cache === false) {
            new ERestException(Yii::t('Api', 'Auth error with key "{key}"', array('{key}'=>$key)));
            return false;
        }
        Yii::app()->controller->module->render->setContentType($cache['type']);
        return true;
    }

}
