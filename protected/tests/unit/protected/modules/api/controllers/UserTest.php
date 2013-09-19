<?php
class UserTest extends CTestCase
{
	public $users = array(1);
	
	public function testGetUsers(){
		$users = new Users();
		$this->assertTrue(($users instanceof ERestDocument));
		
		foreach($this->users as $uid){
			$userInfo = $users->getInfo(array('id' => $uid));
			$this->assertEquals($userInfo->success, 1, 'Server social return false');
			$this->assertEquals($userInfo->message->id, $uid);
		}
	}
	
	public function testGetInfoByIds(){
		$users = new Users();
		$this->assertTrue(($users instanceof ERestDocument));
		
		for($i =1; $i < 20; $i++){
			$randAdvs = Adverts::model()->findAll(array('order' => 'rand()', 'limit' => 10));
			foreach($randAdvs as $randAd){
				$ids[] = $randAd->user_id;
			}
			$userInfo = $users->getInfoByIds(array('ids' => $ids));
			$this->assertEquals($userInfo->success, 1, 'Server social return false');
			foreach($userInfo->message as $u){
				$this->assertTrue(in_array($u->id, $ids));
			}
		}
	}
	
}