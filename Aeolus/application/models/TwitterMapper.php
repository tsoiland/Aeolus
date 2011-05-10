<?php
class Application_Model_TwitterMapper
{
 	function fetchAll() 
 	{
 		$twitter  = new Zend_Service_Twitter_Search('json');
		$searchresults  = $twitter->search('#aeolusdms', array('lang' => 'en'));
		$tweets = $searchresults['results'];
		
		$models = array();
		foreach ($tweets as $tweet) {
			$model = new Application_Model_Incident();
			$model->setTitle(substr($tweet['text'], 0, 50));
			$model->setDescription($tweet['text']);
			$model->setTwitterId($tweet['id']); 			
			$models[] = $model;
		}
		
		return $models;
 	}
 	function eliminateDuplicates(&$models, $dbMapper)
 	{
 		foreach ($models as $key => $model) {
 			if($dbMapper->twitterIdExists($model->getTwitterId())) {
 				unset($models[$key]);
 			}
 		}
 	}
}
?>