<?php

/**
 * Notify command
 * @example yiic notify productcost --models=comments_news --models=comments_news2...
 */
class NotifyCommand extends ConsoleCommand
{
    public $fromQueue = false;

    public function actionProductCost()
    {
        $aProductId = array();
        $time = time();

        $subscribers = Notify::model('Product_Cost')->findAll();
        foreach ($subscribers as $subscriber) {
            $aProductId[$subscriber->product_id] = $subscriber->product_id;
        }

        $apiModel = new Api_Products();
        $minPriceResponce = $apiModel->getCosts('min', array('id' => $aProductId));
        if (!$minPriceResponce || !is_array($minPriceResponce)) {
            $errors = $apiModel->getErrors();
            Yii::log($errors, CLogger::LEVEL_INFO);
            Yii::app()->end();
        }
        $productForSend = array();
        $userForNotify = array();
        foreach ($minPriceResponce as $product) {
            foreach ($subscribers as $subscriber) {
                if ($product->id == $subscriber->product_id) {
                    if ($subscriber->cost >= $product->cost) {

                        $productForSend[$subscriber->product_id] = $subscriber->product_id;
                        $userForNotify[$subscriber->user_id][$subscriber->product_id] = array(
                            'product_id'    => $subscriber->product_id,
                            'cost'          => $product->cost,
                            'subscriber_id' => $subscriber->id);
                    }
                }
            }
        }
        if (count($productForSend) == 0) {
            echo "no notice";
            Yii::app()->end();
        }
        $productInfo = $apiModel->getInfo('attr', array('id' => $productForSend, 'list' => array('title', 'url', 'image'), 'image_size' => 'small'));

        if (!$productInfo) {
            $errors = $apiModel->getErrors();
            Yii::log($errors, CLogger::LEVEL_INFO);
            Yii::app()->end();
        }
        $productInfo = get_object_vars($productInfo);
        foreach ($userForNotify as $userId => $products) {

            $user = Users::model()->findByPk($userId);
            $mail = new Mail();
            foreach ($products as $product) {
                News::pushPriceDown($user, $product, $productInfo[$product['product_id']]);
                $mail->send($user, 'notifyProductCost', array(
                    'date'        => $time,
                    'cost'        => $product['cost'],
                    'productId'   => $product['product_id'],
                    'productName' => $productInfo[$product['product_id']]->title
                ));
                Notify::model('Product_Cost')->deleteByPk($product['subscriber_id']);
            }
        }
    }

}
