<?php

/**
 * This is the model class for table "news_comments".
 *
 * The followings are the available columns in table 'news_comments':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $entity_id
 * @property integer $user_id
 * @property string $text
 * @property integer $likes
 * @property integer $dislikes
 * @property integer $status
 * @property integer $level
 * @property integer $created_at
 * @property integer $updated_at
 */
class Bookmarks extends ActiveRecord
{


    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return NewsComments the static model class
     */
    public static function model($className = __CLASS__, $new = false)
    {
        if ($className != __CLASS__) {
            $className = 'Bookmarks_' . $className;
        }
        return parent::model($className, $new);
    }
	
	public static function sinchronize($type, $user_id, array $data){
	
		$sections = array();
		
		self::model($type)->deleteAll('user_id = :id', array(':id' => $user_id));
		
		if(!count($data)){
			return false;
		}

		foreach($data as $id => $prod){
			if(!isset($prod['section_id']) || !$prod['section_id']){
				$prod['section_id'] = 0;
			}

			if($prod['section_id'] && !array_key_exists($prod['section_id'], $sections)){
				$sectionName = Yii::app()->cache->get('sections_name_' . $prod['section_id']);
				if(!$sectionName){
					$model = Catalog_Sections::model();
					$model = $model->find('section_id = :id', array(':id' => $prod['section_id']));
					if($model){
						$sections[$prod['section_id']] = $model->name;
					} else {
						$sections[$prod['section_id']] = null;
					}
				}
			}
			$class = 'Bookmarks_' . $type;
			$model = new $class();
			$model->attributes = $prod;
			$model->user_id = $user_id;
			$model->product_id = $id;
			$model->save();
		}
	}
    
}
