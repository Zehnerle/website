<?php

class Paginator{

	private $total;
	private $offset;
	private $page;
	private $pages;
	private $pagesDisplayed;
	private $start;
	private $end;
	
	//Constructor for the class paginator
	public function __construct($total) {
	
		$this->total = $total;
		$this->limit = 10;	
		$this->pagesDisplayed = 9;
		$this->setup();
	
	}
	
	private function setup() {
	
		$this->pages = ceil($this->total / $this->limit);
		
		$this->page = min($this->pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
			'options' => array(
				'default'   => 1,
				'min_range' => 1,
			),
		)));
		
		$this->offset = ($this->page - 1) * $this->limit;
		// Some information to display to the user
		$this->start = $this->offset + 1;
		$this->end = min(($this->offset + $this->limit), $this->total);
		
	}
	
	// site and tag in case of special pages, e.g. search function
	public function display($site, $tag) {	
	
		$link = '<a href="' . $site . '?'. $tag .'page=';

		$prevlink = ($this->page > 1) ? 			
			$link . 1 . '">&laquo;</a> '
			. $link . ($this->page - 1) . '">&lsaquo;</a>'
			: '<span>&laquo;</span> <span>&lsaquo;</span>';				
			
		$nextlink = ($this->page < $this->pages) ?
			$link . ($this->page + 1) . '">&rsaquo;</a> '
			. $link . $this->pages . '">&raquo;</a>'
			: '<span>&rsaquo;</span> <span>&raquo;</span>';

		$dOffset = $this->calcDisplay();
		$pagelist = $this->concatDisplay($dOffset, $site, $tag);
		echo '<div id="paging"><p>', $prevlink, $pagelist, $nextlink, '</p></div>';
		
	}
	
	private function calcDisplay() {
		
		if($this->pages <= $this->pagesDisplayed) {		
			$this->pagesDisplayed = $this->pages;	
			$dOffset = 1;		
		}
		
		else {
				
			$numHalf = round($this->pagesDisplayed/2, 0, PHP_ROUND_HALF_DOWN);					
			$dOffset = $this->page - $numHalf;		
				
			if($dOffset < 1)
				$dOffset = 1;

			else if(($this->page + $numHalf) > $this->pages)
				$dOffset = $this->pages - ($this->pagesDisplayed - 1);	
			
		}

		return $dOffset;
		
	}
	
	private function concatDisplay($dOffset, $site, $tag) {
	
		$string = "";
		$i = $this->pagesDisplayed;
		
		while($i != 0) {
		
			if ($dOffset == $this->page) 
				$string .= ' <strong>'.$dOffset.'</strong> ';
			else 
				$string .= ' <a href="' .$site. '?' . $tag 
				. 'page=' . $dOffset . '">'.$dOffset.'</a> ';
			$i--;
			$dOffset++;			
		}	

		return $string;
	}
	
	public function getQuery() {
		return "ORDER BY title LIMIT $this->limit OFFSET $this->offset";
	}

}

?>
