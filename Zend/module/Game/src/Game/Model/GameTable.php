<?php

	namespace Game\Model;

	use Zend\Db\TableGateway\TableGateway;
	use Zend\Db\Sql\Where;

	class GameTable {
	
		protected $tableGateway;

		public function __construct(TableGateway $tableGateway) {
			$this->tableGateway = $tableGateway;
		}
		
		public function getGateway() {
			return $this->tableGateway;
		}
		
		public function fetchOpenGames() {
			$where = new Where();    
			$where->literal("winner IS NULL", NULL);

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

		public function saveGame(Game $game) {
		
			$data = array(
				'player1' => $game->player1,
				'player2' => $game->player2,
				'mail1' => $game->mail1,
				'mail2' => $game->mail2,
				'choice1' => $game->choice1,
				'choice2' => $game->choice2,
				'winner' => $game->winner,
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
		
		public function deleteGame($id) {
			$this->tableGateway->delete(array('id' => $id));
		}
	}

?>