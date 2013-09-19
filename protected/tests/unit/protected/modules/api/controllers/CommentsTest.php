<?php
class CommentsTest extends CTestCase
{
	
	public function testGetEntityList(){
		$type = 'adverts';
		
		$comments = Comments::model();
		$adverts = Adverts::model()->findAll(array('order' => 'rand()', 'limit' => 30));
		foreach($adverts as $adv){
			$advComments = $comments->getEntityList($type, array('id' => $adv->id));
			$this->assertEquals($advComments->success, 1);
			if($advComments->count > 0){
				foreach($advComments->comments as $comm){
					$this->assertEquals($comm->entity_id, $adv->id);
				}
			}
		}	
	}
	
	public function testGetEntityUserList(){
		$apiComments = Comments::model();
		$res = $apiComments->getEntityUserList('adverts', array('id' => 288, 'user_id' => 1));
		$this->assertEquals($res->success, 1);
		$this->assertTrue(($res->count > 0));
	}
	
	public function testGetEntityPopular(){
		$apiComments = Comments::model();
		$res = $apiComments->getEntityPopular('adverts');
		$this->assertTrue(is_array($res));
	}
	
	public function testGetEntityCount(){
		$apiComments = Comments::model();
		$res = $apiComments->getEntityCount('adverts', array('id' => array(54)));
		$this->assertTrue((array_pop($res->comments)->count > 20));
	}
	
	public function testPostEntity(){
		
		$advert = Adverts::model()->find('user_id = 1 AND status = 2');
		
		$criterea = new EMongoCriteria();
        $criterea->addCond('user_id', '==', '1');
        $news     = Mongo_News::model()->find($criterea);
		foreach($news->entities as $key => $n){
			if($n->entity_id = $advert->id && $n->template == 'newsAuthor'){
				unset($news->entities[$key]);
			}
		}
		$news->save();
		$count = count($news->entities);

		$text = $count . 'message' . time();
		
		$apiComments = Comments::model();
		$res = $apiComments->postEntity('adverts', array('user_id' => 1, 'entity_id' => $advert->id, 'parent_id' => 0, 'text' => $text));
		$this->assertEquals($res->success, 1);
		
		$criterea = new EMongoCriteria();
        $criterea->addCond('user_id', '==', '1');
        $news     = Mongo_News::model()->find($criterea);
		
		$this->assertEquals(count($news->entities), $count+1);
		foreach($news->entities as $key => $n){
			if($n->entity_id = $advert->id && $n->template == 'newsAuthor'){
				unset($news->entities[$key]);
			}
		}
		unset($news->entities[$yes]);
		$this->assertTrue($news->save());
	}
}