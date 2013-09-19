<?php
class YamaTags extends QWidget {

	const LIMIT = 14;

	public $viewFile = 'yamatags';
	public $tags = array();
	public $limit = 14;
	
	public function init(){
		if(empty($this->tags)){
			if(!$this->tags = Yii::app()->cache->get('pupular_tags_for_yama_index_' . $this->limit)){
				$this->tags = Tags::model()->getPopularTags(array('limit' => $this->limit));
				Yii::app()->cache->set('pupular_tags_for_yama_index_' . $this->limit, $this->tags, 3600);
			}
		}
		$this->addScript();
		$this->setData(array('tags' => $this->tags));
	}

	protected function addScript(){
		Yii::app()->clientScript->registerScript('moreTags',
			'jQuery(".b-market__tags-line").on("click", ".last", function(){
				search = $("#searchYama").val();
				jQuery.get("' . Yii::app()->getBaseUrl(true) . '/site/getMoreTags' . '", {q: search}, function(response){
					$(".b-market__tags-line").html(response)
				});
			})'
		);
	}
}