<?php
//Class article that contans a title and a content, and the getter and setter methodes
class article
{
	private $title;
	private $content;
	
	//Constructor of the class article
	public function __construct($Titel, $Content){
		$this->title = $Titel;
		$this->content = $Content;
	}

	//Set the title of the article
	public function __setTitle($Title){
		 $this->title = $Title;	
	}
	
	//Set content of the article
	public function __setContent($Content){
		 $this->content = $Content;
	}

	//Get the title of an article
	public function __getTitle(){
		return $this->title;
	}

	//Get the content of the article
	public function __getContent(){
		return $this->content;
	}
}
?>
