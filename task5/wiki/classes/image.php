<?php

class Image {

	private $tablename;	
	private $imgfolder; 
	private $imgdefault;
	private $alignment;
	private $tempimage;
	
	private static $instance;
	
	public function __construct() {
		$this->tablename = 'article';
		$this->imgfolder = "articleimages/";
		$this->imgdefault = "NOIMG";
		$this->alignment = "right";
		$this->tempimage = "temp.png";
	}
	
	public static function getImage() {
	
		if(!isset(self::$instance)) {
			self::$instance = new Image();
		}
		
		return self::$instance;
	}	
	
	function getTempImage() {
		return $this->tempimage;
	}
	
	function getDefaultImage() {
		return $this->imgdefault;		
	}	
	
	function getImagePath($image) {
		return $this->imgfolder . $image;
	}
	
	function storeTempImage($file) {
		
		$path = $this->imgfolder . $this->tempimage;
		
		if(!move_uploaded_file($file, $path)){
			echo "Fehler beim Kopieren!";
		}
		
		return $this->tempimage;
	}
	
	function storeImage($id, $file) {
		
		$image = $id . ".png";
		$path = $this->imgfolder . $image;
		
		if(!move_uploaded_file($file, $path)){
			echo "Fehler beim Kopieren!";
		}
		
		return $image;
	}
	
	function renameImage($src, $dest) {	
		$src = $this->imgfolder . $src;
		$dest = $this->imgfolder . $dest;
		
		if(is_file($src))
			rename($src, $dest);
	}
	
	function removeImage($image) {
	
		$path = $this->imgfolder . $image;
		if(is_file($path))
			unlink($path);
			
		echo "Bild entfernt!";
	}
	
	function insertImage($id, $alignment, $image) {	
		DB::getDB()->query("UPDATE article
			SET image = '$image', 
			alignment = '$alignment'
			WHERE id = '$id'"
		);
	}
	
	function changeAlignment($id, $alignment) {	
		DB::getDB()->query("UPDATE article
			SET alignment = '$alignment'
			WHERE id = '$id'"
		);
	}
	
	function deleteImage($image) {		
		$result = DB::getDB()->query("UPDATE article		
			SET image = DEFAULT
			WHERE image LIKE '$image'");		
	}
	
	function displayOldImage($image, $alignment) {	
				
		return "
			<img src='" . $this->imgfolder . $image . "' class='article' />
			<input type='hidden' name='image' value='". $image ."' />
			<input type='hidden' name='alignment' value='". $alignment ."' />
			<p class='img'>Angeh&auml;ngt: " . $image .	"</p>";
			
	}
	
	function displayImage($image, $alignment) {	
				
		return "
			<img src='" . $this->imgfolder . $image . "' alt='" . $image . "' class='article' />
			<input type='hidden' name='image' value='". $image ."' />
			<input type='hidden' name='alignment' value='". $alignment ."' />
			<p class='img'>Angeh&auml;ngt: " . $image .
			"</p><input type='submit' name='imgchange' value='Bild bearbeiten' />
			<input type='submit' name='imgdelete' value='Bild l&ouml;schen' />";
			
	}
	
	function displayInputField() {	

		return "
			<input type='file' name='image' />
			<input type='submit' name='imgupload' value='Hochladen!' />
			<br /><br />
				Bildausrichtung: <select name='alignment'> 
				  <option selected>right</option>
				  <option>left</option>
				</select> <input type='submit' name='imgupload' value='Ok!' /><br /><br />";
	}
		
}
?>
