<?php

/**
 * Notify command
 * @example yiic notify productcost --models=comments_news --models=comments_news2...
 */
class SearchCommand extends ConsoleCommand
{
    public $fromQueue = false;

    public function actionSynchronize()
    {
        $model = Search::model()->findAll('is_send = 0');
		foreach($model as $search){
			Tags::model()->postSearch(1, array('text' => $search->value, 'is_good' => $search->is_good, 'user' => $search->user_id));
		}
		Search::model()->updateAll(array('is_send' => 1));
    }

}
