<?php

class AhimsaSearchService {
	
	public static function prepareData($strSearch, $limit = 10, $offset = 0, $region = 0, $category = 0, $tagsLimit = 14){
		$ids = array();
		$full = array();
		$all = array();

		$strSearch = trim($strSearch);
		$strSearch = strip_tags($strSearch);
		$strSearch = mb_ereg_replace('[\W]', ' ', $strSearch);
		$strSearch2 = implode(' | ', explode(' ', $strSearch));
		 
		$cl = Yii::App()->sphinx;
		$cl->SetConnectTimeout(1);
		$cl->SetWeights(array(100, 1));
		//$cl->SetMatchMode($MatchMode);
		
		$cl->SetLimits($offset = 0, $limit = 1000, $max_matches = 1000, $cutoff = 0);
		$cl->SetRankingMode(SPH_RANK_PROXIMITY_BM25);
		$cl->SetSortMode(SPH_SORT_RELEVANCE);
		
		$cl->SetArrayResult(true);
		
		$cl->AddQuery("{$strSearch}", "index_ahimsa");
		$cl->AddQuery("{$strSearch2}", "index_ahimsa");
		
		$res = $cl->RunQueries();
		
		if(is_array($res)){
			if(isset($res[0]['matches'])){
				foreach($res[0]['matches'] as $m){
					$full[$m['id']] = array('id' => $m['id'], 'weight' => $m['weight']);
					$ids[$m['id']] = $m['id'];
				}
			}
			if(isset($res[1]['matches'])){
				foreach($res[1]['matches'] as $m){
					$all[$m['id']] = array('id' => $m['id'], 'weight' => $m['weight']);
					$ids[$m['id']] = $m['id'];
				}
			}
		}
		if(empty($ids)){
			return array('res' => array(), 'tags' => array());
		}
		
		$all = array_diff_key($all, $full);
		
		$tags = Tags::model()->getTagsByEntities(array('entities' => $ids, 'entity_type_id' => 4, 'limit' => $tagsLimit, 'text' => $strSearch));
		$levels = array();
		foreach($all as $ent){
			$levels[$ent['weight']] = $ent['weight'];
		}

		$sIds = implode(',', $ids);
		$condition = "id IN ({$sIds}) AND status = 1";
		if($region){
			$condition .= ' AND region = ' . $region->id;
		}
		if($category){
			$condition .= ' AND category = ' . $category->id;
		}
		$model = Adverts::model()->findAll(
			array('condition' => $condition, 'order' => 'last_up DESC', 'limit' => $limit, 'offset' => $offset)
		);
		$res = array();
		krsort($levels);
		
		foreach($full as $f){
			foreach($model as $m){
				if($m->id == $f['id']){
					$m->top = true;
					$res[$m->id] = $m;
				}
			}
		}
		
		foreach($levels as $l){
			foreach($model as $k => $m){
				foreach($all as $ent){
					if($ent['id'] == $m->id && $ent['weight'] == $l){
						$res[$m->id] = $m;
						unset($model[$k]);
					}
				}
			}
		}
		return array('res' => $res, 'tags' => $tags);
	}
	
}