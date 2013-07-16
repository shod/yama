<?php
// yiic mail send --actions=10
class SitemapCommand extends ConsoleCommand {

	public $fromQueue = false;
	public $all = false;
	public $productsInFile = 8000;
	public $block;

    public function actionCreate() {
		$renderer = new QSitemapRenderer();
		if($this->all){
			$this->createMainXml();
		}
		
		switch($this->block){
			case 'main':
				$this->createMainXml();
				break;
		}
		echo '!!!END!!!';
    }
	
	public function createMainXml(){
		
		$data = array();
		// MAIN
		
		$data[] = array(
			'url' => array(
				'loc' 			=> Yii::app()->params['yamaBaseUrl'],
				'changefreq' 	=> 'daily',
				'priority' 		=> 0.8,
				'lastmod' => date('Y-m-d')
			),
		);
		
		// SECTIONS
		$sql="select * from adverts where status = 1";
		$command=Yii::app()->db->createCommand($sql);
		$rows = $command->queryAll();
		
		foreach ((array) $rows as $r)
		{
			$data[] = array(
				'url' => array(
					'loc' 			=> Yii::app()->params['yamaBaseUrl'] . 'ahimsa/' . $r['id'],
					'changefreq' 	=> 'daily',
					'priority' 		=> 1,
				),
			);
		}
		
		$renderer = SiteMapRenderer::model('XML');

		$renderer->setFileName('main.xml')
			->setGzip(false)
		;

		$renderer->setData($data);
		
		$renderer->save();
		//$renderer->createMainLink();
		
		return true;
	}
}