<?php

class Api_AuctionNotify extends ERestDocument
{
    public $id;

	public function attributeNames()
    {
        return array();
    }

    public function getCollectionName()
    {
        return 'AuctionNotify';
    }

    /**
	 * Get ERest component instance
	 * By default it is ERest application component
	 *
	 * @return ERest
	 * @since v1.0
	 */
	public function getRestComponent()
	{
		return $this->setRestComponent(Yii::app()->getComponent('social'));
	}

    public static function model($className='AuctionNotify')
	{
		return parent::model($className);
	}

}
