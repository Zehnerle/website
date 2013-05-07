<?php

	class Generator {
	
		private $total;
		private $maxLength;
		private $tablename;
		private $articles;
		private $size;
		
		private $elementsInDB;
		private $numElementsInDB;
		
		private $titleChars;
		private $articleChars;
	
		public function __construct($total = 1, $max = 1) {	
		
			$this->total = $total;
			$this->maxLength = $max;
			$this->tablename = 'article';			
			$this->elementsInDB = array();		

			// valid chars for random generated strings
			$this->titleChars = "abcdefghijklmnopqrstuvwxyz" 
						."ABCDEFGHIJKLMNOPQRSTUVWXYZ";	
			$this->articleChars = $this->titleChars . "* \n\n";
			
		}
	
	
		public function generate() {	
				
			$this->getElementsInDB();	
			
			$this->articles = array();
		
			for ($this->size = 0; $this->size < $this->total; $this->size++) {		
			
				$length = mt_rand(5, 15);
				$title = $this->getRandomString($this->titleChars, $length);
			
				$length = mt_rand(1, $this->maxLength);				
				$content = $this->getRandomString($this->articleChars, $length);
				
				$this->articles[$this->size] = new Article($title, $content);
				
			}		
			
			$this->insertAll();	
		
		}
		
		
		private function getElementsInDB() {
			
			$this->numElementsInDB = DB::getDB()->totalNumber("article"); 		
		
			$query = DB::getDB()->query("SELECT * FROM article");
			
			$i = 0;
			
			if($query != FALSE) {
				while($article = mysql_fetch_object($query)){
					$this->elementsInDB[$i] = $article;
					$i++;
				}		
			}
		}
		
		
		private function getRandomString($validChars, $length) {
		
			$string = "";
			$linkCounter = 0;
			$numValidChars = strlen($validChars);

			for ($i = 0; $i < $length; $i++) {
							
				$random = mt_rand(1, $numValidChars);
				$randomChar = $validChars[$random-1];
	
				if($randomChar == "*" && $linkCounter < 2) {
					$randomChar = $this->getRandomLink();
					$linkCounter++;
				}				
				
				$string .= $randomChar;
			}
			
			return $string;
		}
		

		private function getRandomLink() {		

			$string = "";
			$random = mt_rand(0, $this->numElementsInDB);
			
			if(isset($this->elementsInDB[$random])){
				$title = $this->elementsInDB[$random]->title;
				$string =  " [[" . $title . "]] ";
			}
			
			return $string;
			
		}		
		
		
		private function insertAll() {

			$parser = new Parser(); 
			
			$insertLimit = 200;		//inserts in 200er steps
			$counter = 0;
			
			$articlesString = array();
			$linksString = array();
			
			foreach ($this->articles as $value) {	
			
				$html = $parser->parseToHtml($value->getContent());	

				$articlesString[] = "('" . $value->getTitle() . "','" 
					. $value->getContent() . "','" . $html . "', 1)";
				
				$result = $parser->returnLinksArray($value->getTitle());
				$linksString = array_merge($linksString, $result);
				
				$counter++;
								
				if($counter > $insertLimit) {
				
					$this->insertInDB($articlesString, $linksString);
					
					$articlesString = array();
					$linksString = array();
					$counter = 0;
					
				}
				
			}	
			
			$this->insertInDB($articlesString, $linksString);
		
		}
	
		private function insertInDB($articlesString, $linksString) {
		
			DB::getDB()->query("INSERT INTO article(title, content, html, generated)
						VALUES" . implode(",", $articlesString));
					
			// replace from-titles by new created ids
			$temp = $this->getLinkString($linksString);		
			
			DB::getDB()->query("INSERT INTO links VALUES" . implode(",", $temp));
			
		}
		
		
		private function getLinkString($links) {
			
			$temp = array();
			
			foreach ($links as $value) {
				
				$from = $value[0];
				
				$query = DB::getDB()->query("SELECT id FROM article WHERE title LIKE '$from'");
				$row = mysql_fetch_assoc($query);
				
				$subString = "(" . $row['id'] . ", " . $value[1]. ")";
				
				if(!in_array($subString, $temp)) 
					$temp[] = $subString;
					
			}
			
			return $temp;
			
		}		
		
		public function deleteAll() {		
			DB::getDB()->delete($this->tablename, " WHERE generated = 1");	
		}	 			
		
	}

?>
