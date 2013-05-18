<?php

	namespace Game\Model;

	use Zend\Db\TableGateway\TableGateway;
	use Zend\Db\Sql\Sql;
	use Zend\Db\Sql\Where;
	use Zend\Db\Sql\Select;
	use Zend\Db\Sql\Expression;

	class GameTable {
	
		protected $tableGateway;
		protected $scoreGateway;

		public function __construct(TableGateway $tableGateway, TableGateway $scoreGateway) {
			$this->tableGateway = $tableGateway;
			$this->scoreGateway = $scoreGateway;
		}
		
		public function getGateway() {
			return $this->tableGateway;
		}
		
		public function fetchOpenGames($user) {
			$where = new Where(); 
			$query = "(player1 LIKE '$user' OR player2 LIKE '$user') "
					. "AND winner IS NULL";
			$where->literal($query, NULL);

			$resultSet = $this->tableGateway->select($where);
			return $resultSet;
			
		}
		
		public function fetchClosedGames($user) {
			$where = new Where();    
			$query = "(player1 LIKE '$user' OR player2 LIKE '$user') "
					. "AND winner IS NOT NULL";
			$where->literal($query, NULL);

			$resultSet = $this->tableGateway->select($where);
			return $resultSet;
			
		}

		public function getGame($id) {
		
			$id  = (int) $id;
			$rowset = $this->tableGateway->select(array('id' => $id));
			$row = $rowset->current();
			if (!$row) {
				throw new \Exception("Could not find row $id");
			}
			return $row;
		}
		
		public function getGameByHash($hash) {
		
			$rowset = $this->tableGateway->select(array('hash' => $hash));
			$row = $rowset->current();
			if (!$row) {
				throw new \Exception("Could not find row $hash");
			}
			return $row;
			
		}
		
		public function getHighscore() {
		
			$sql = new Sql($this->scoreGateway->getAdapter());
			
			$select = new Select();
			$count = new Expression("COUNT(DISTINCT player1)");
			
			$select->from('game')
				->columns(array('winner', 'num' => $count))
				->group('winner')
				->order("num DESC, winner ASC")->limit(10)
				->where("winner IS NOT NULL AND winner NOT LIKE 'TIE'");
				
		//	echo $select->getSqlString(); 

			$resultSet = $this->scoreGateway->selectWith($select);
			return $resultSet;			
			
		}

		public function saveGame(Game $game) {
		
			$data = array(
				'player1' => $game->player1,
				'player2' => $game->player2,
				'mail1' => $game->mail1,
				'mail2' => $game->mail2,
				'choice1' => $game->choice1,
				'choice2' => $game->choice2,
				'winner' => $game->winner,
				'hash' => $game->hash,
			);

			$id = (int)$game->id;
			
			if ($id == 0) {
				$this->tableGateway->insert($data);
			} else {
				if ($this->getGame($id)) {
					$this->tableGateway->update($data, array('id' => $id));
				} else {
					throw new \Exception('Form id does not exist');
				}
			}
			
		}
		
		public function deleteGame($hash) {
			$this->tableGateway->delete(array('hash' => $hash));
		}
	}

?>