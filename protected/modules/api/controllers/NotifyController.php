<?php

/**
 * Notify user
 * @package api
 */
class NotifyController extends ERestController
{

    const EXCEPTION_COST_MUST_BE_MORE_ZERO = 'Cost must be more zero';
    const EXCEPTION_USER_IS_NOT_EXIST = 'User is not exist';


    /**
     * Add notify about change product cost
     * @param type $id - product id
     * @param float $cost - product cost
     * @throws ERestException
     */
    public function actionPostProductCost($id)
    {
        $userId = (int) Yii::app()->request->getParam('user_id');
        $cost = (float) Yii::app()->request->getParam('cost');
        if(!Users::model()->findByPk($userId)){
            throw new ERestException(Yii::t('Notify', self::EXCEPTION_USER_IS_NOT_EXIST));
        }

        if($cost == 0){
            throw new ERestException(Yii::t('Notify', self::EXCEPTION_COST_MUST_BE_MORE_ZERO));
        }

        $model = new Notify_Product_Cost();
        $model->product_id = (int)$id;
        $model->cost = (float) Yii::app()->request->getParam('cost');
        $model->user_id = $userId;
        try {
            $model->save();
        } catch (Exception $exc) {
            throw new ERestException(Yii::t('Notify', $exc->getMessage()));
        }
        $this->render()->sendResponse(array(ERestComponent::CONTENT_SUCCESS => true));
    }

}