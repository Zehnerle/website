<?php

	namespace Game\Model;	
	
	use \MongoClient;
	use \MongoCode;
	use \MongoCursor;
	
	class MongoGameTable {
	 
		private static $instance;
		private $collection;	
		
		private function __construct() {
			$db = new MongoClient();
			$db = $db->website;
			$this->collection = $db->game;			
		}
		
		public static function getDB() {
		
			if(!is_object(self::$instance))
				self::$instance = new MongoGameTable();
			
			return self::$instance;
			
		}
		
		
		public function getGameByHash($hash) {	
			
			$game = new Game();
			$doc = $this->collection->findOne(array('hash' => $hash));	
			$game->exchangeArray($doc);
			return $game;
			
		}
		
		public function fetchOpenGames($user) {
		
			$where = array('$and' => array(			
						array('$or' => array(
						  array('player1' => $user),
						  array('player2' => $user),
						)),
						array('winner' => null),
			));
		
			$cursor = $this->collection->find($where);
			return $this->cursorToGameArray($cursor);
			
		}
		
		public function fetchClosedGames($user) {
			
			$where = array('$and' => array(			
						array('$or' => array(
						  array('player1' => $user),
						  array('player2' => $user),
						)),
						array(
							'winner' => array(
							'$ne' => null
							)
						),
			));
		
			$cursor = $this->collection->find($where);
			return $this->cursorToGameArray($cursor);
		
		}
		
		private function cursorToGameArray($cursor) {
			
			$array = array();
			
			foreach($cursor as $doc) {
				$game = new Game();
				$game->exchangeArray($doc);
				array_push($array, $game);
			}

			return $array;
		
		}
		
		public function insertGame($game) {	
		
			$hash = $game->hash;

			if ($hash == null)
				$this->collection->insert($game);
			else 
				$this->collection->update(array('hash' => $hash), $game);
		}
		
		
		public function deleteGame($hash) {	
			
			$where = array('hash' => $hash);			
			$this->collection->remove($where);	
			
		}
		
		public function getHighscore() {
						
			$group = array(
						'$group' => array(
							'_id' => '$winner',
							'num' => array('$sum' => 1),								
						),
					);					
			$sort = array('$sort' => array('num' => -1));								
			$limit = array('$limit' => 12);						
						
			$cursor = $this->collection->aggregate($group, $sort, $limit);	
			
			$counter = 0;
			
			foreach ($cursor['result'] as $key => $winner) {
			
				if($winner['_id'] === null || $winner['_id'] === 'TIE')
					unset($cursor['result'][$key]);	
				
				else if ($counter > 10)
					unset($cursor['result'][$key]);	

				$counter++;
				
			}			
			
			return $cursor['result'];
		}
		

	} 
	
?>
