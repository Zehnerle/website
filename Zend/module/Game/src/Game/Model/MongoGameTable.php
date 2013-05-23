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
			
			if ($hash == 0)
				$this->collection->insert($game);
			else
				$this->collection->update(array('hash' => $hash), $game);
			
		}
		
		
		public function deleteGame($hash) {	
			
			$where = array('hash' => $hash);			
			$this->collection->remove($where);	
			
		}
		
		public function getHighscore() {
			
			$array = array();		
			
			$keys = array('winner' => true);
			$initial = array('num' => 0);
			$reduce = "function (obj, prev) { prev.num++; }";
			
			$condition = array('condition' => 
					array('$and' => array(
							array('winner' => array('$ne' => null)),
							array('winner' => array('$ne' => 'TIE')),
					))
				);

			$cursor = $this->collection->group($keys, $initial, $reduce, $condition);			
		
			usort($cursor['retval'], function($a, $b) {
				return $b['num'] - $a['num'];
			});
			
			$cursor['retval'] = array_slice($cursor['retval'], 0, 10);
		
			return $cursor['retval'];
		}
		

	} 
	
?>
