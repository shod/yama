<?php
/**
 * Cross-server authentication
 * @package api
 */
class AuthController extends ERestController {

    private $salt = 'al&hhGFFDYbeHappy';

    /**
     * Auth method
     * @param string $key - Sicret key for auth
     * @param string $type - Return content format. For example 'json'.
     * @uses Auth::getLogin()
     * @tutorial
     * $model = new AuthApi();
     * $responce = $model->getLogin('Sicret_key', array('type' => 'json'));
     * @return suid
     * @example json {'method':'GET','status':'OK','code':200,'content':{'suid':'3da7b280eda538c15f2bff38afd11dcd'},'format':'json','timestamp':1348645528,'version':'1.0'};
     * @expectedExceptionMessage Not auth
     */
    public function actionGetLogin($key, $type = ERestRender::TYPE_JSON) {
        $keys = $this->module->keys;
        $render = $this->render();
        $type = strtolower($type);
        if (!$render->isValidType($type)) {
            $render->setStatus(ERestComponent::STATUS_BAD_REQUEST)->sendResponse(array('message' => Yii::t('Api', 'Invalid type ' . $type)));
        }
        $render->setContentType($type);

        if (array_key_exists($key, $keys) && $keys[$key] == CHttpRequest::getUserHostAddress()) {
            $suid = md5($key . $this->salt . $keys[$key] . $type);
            Yii::app()->cache->set($suid, array('type' => $type));
            $render->sendResponse(array('suid' => $suid));
            return true;
        } else {
            $render->setStatus(ERestComponent::STATUS_BAD_REQUEST)->sendResponse(array('message' => Yii::t('Api', 'Not auth')));
        }

    }

    /**
     * Default api page
     */
    public function actionIndex()
    {
        $this->render()->sendResponse('Welcome to migom API');
    }

    public function actionKeyNotFound()
    {
        $this->render()->setStatus(ERestComponent::STATUS_BAD_REQUEST)->sendResponse(array('message' => Yii::t('Api', 'Key not found')));
    }

    public function actionPageNotFound()
    {
        $errors = Yii::app()->getErrorHandler()->getError();
        $this->render()->setStatus($errors['code'])->sendResponse(array(ERestComponent::CONTENT_MESSAGE => $errors['message'],
            ERestComponent::CONTENT_SUCCESS => false));
    }
}