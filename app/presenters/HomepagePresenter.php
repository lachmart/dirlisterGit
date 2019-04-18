<?php
namespace App\Presenters;
use Nette\Application\Responses\FileResponse;

//include("../../qc.fnol.loc/app/model/enum/Constant.php");
//define("DIR_ROOT", \fnolQc\enum\Constant::DIR_ROOT);
//define("DIR_ROOT", "/mnt/FS17/data/");
define("DIR_ROOT", "../vendor");
//define("DIR_ROOT", "..");
//define("DIR_DEFAULT", "\dezinfekce");
define("DIR_DEFAULT", "");
//define("DIR_DEFAULT", "/data");
define("maxFilenameLengh",60);
define("maxFilenameLenghTree",10);


class HomepagePresenter extends BasePresenter
{
	private $firstLevel = array();
	private $fileIndex = 0;

	public function renderDefault($dir = DIR_DEFAULT)
	{
		$this->template->dir = $dir;
		//$this->template->dir = $httpRequest->getQuery('dir');
		$this->template->dirtree = $this->getDirtree(DIR_ROOT);
		$this->template->files = $this->getFiles(DIR_ROOT.$dir);
		//var_dump($this->template->dirtree);
	}
	public function renderFind($dir,$file)
	{
		$this->template->dir = $dir;
		$this->getDirtree(DIR_ROOT);
		$this->template->firstLevel = $this->firstLevel;
		if($dir == "" && $file == "")
			$this->template->files =[];
		else
			$this->template->files = $this->findFiles(DIR_ROOT.'/'.$dir, $file);
			if ($this->isAjax()) {
					$this->redrawControl('listing');
			}
	}

	function getDirtree($dir, $regex='', $ignoreEmpty=false, $level = 1)
	{
	//	$this->template->dir = $dir;
	    if (!$dir instanceof \DirectoryIterator) {
	        $dir = new \DirectoryIterator((string)$dir);
	    }
	    $dirs  = array();
	    $files  = array();
			$i = 0;
			$path = "";
	    foreach ($dir as $node) {
	        if ($node->isDir() && !$node->isDot()) {
	            $tree = $this->getDirtree($node->getPathname(), $regex, $ignoreEmpty, $level+1);
	            if (!$ignoreEmpty || count($tree)) {
									$dirs[$i]["text"] =$node->getFilename();
									$path = substr($node->getPathname(),strlen(DIR_ROOT));
									$dirs[$i]["href"] = $path;
	                $dirs[$i]["children"] = $tree;
									$dirs[$i]["imageCssClass"] = 'fa fa-folder';
									if (DIR_ROOT.$this->template->dir == $node->getPathname())
	                	$dirs[$i]["active"] = true;
									else {
										$dirs[$i]["active"] = false;
									}
									$i++;
									$this->template->link = substr($node->getPathname(),strlen(DIR_ROOT));
									if($level == 1)
										array_push($this->firstLevel, $node->getFilename());
						  }
	        }
					else if ($node->isFile()) {
							$name = $node->getFilename();
							if ('' == $regex || preg_match($regex, $name)) {
									$files[$this->fileIndex]["title"] = $name;
									if (strlen($name)>maxFilenameLenghTree)
										$name = substr($name,0,maxFilenameLenghTree-3)."...";
										$files[$this->fileIndex]["text"] = $name;
										$files[$this->fileIndex]["href"] =$this->link(':download',substr($node->getPathname(),strlen(DIR_ROOT)));
										$files[$this->fileIndex]["ext"] = $node->getExtension();
										$files[$this->fileIndex]["size"] = $node->getSize();
										$files[$this->fileIndex]["date"] = date("d. m. Y G:i:s",$node->getMTime());
										$files[$this->fileIndex]["imageCssClass"] = 'fa fa-folder';
										$this->fileIndex++;
							}
					}
	    	}
		//	$this->template->files = $files;
			//$this->template->dirtree = $dirs;
			return $dirs;
	}

	function findFiles($dir, $regex='', $ignoreEmpty=false, $level = 1)
	{
		//$this->template->dir = $dir;
	    if (!$dir instanceof \DirectoryIterator) {
	        $dir = new \DirectoryIterator((string)$dir);
	    }
	    $files  = array();
			$i = 0;
			$path = "";
	    foreach ($dir as $node) {
	        if ($node->isDir() && !$node->isDot()) {
	            $files = array_merge($files,$this->findFiles($node->getPathname(), $regex, $ignoreEmpty, $level+1));
	        }
					else if ($node->isFile()) {
							$name = $node->getFilename();
							if ('' == $regex || preg_match('/'.$regex.'/', $name)) {
									$files[$this->fileIndex] = $this->getFile($node);
										$this->fileIndex++;
							}
					}
	    	}
		//	$this->template->files = $files;
			//$this->template->dirtree = $dirs;
		return $files;
	}

	function getFiles($dir, $regex='', $ignoreEmpty=false)
	{
		//$this->template->dir = $dir;
			if (!$dir instanceof \DirectoryIterator) {
					$dir = new \DirectoryIterator((string)$dir);
			}
			$files = array();
			$i = 0;
			foreach ($dir as $node) {
				if ($node->isFile()) {
					$name = $node->getFilename();
					if ('' == $regex || preg_match($regex, $name)) {
						  $files[$i] = $this->getFile($node);
							$i++;
						}
				}
			}

		return $files;
	}

	function getFile($node)
	{
			$file = array();
			$name = $node->getFilename();
			$file["title"] = $name;
			if (strlen($name)>maxFilenameLengh)
				$name = substr($name,0,maxFilenameLengh-3)."...";
			$file["text"] = $name;
			$file["href"] =$this->link(':download',substr($node->getPathname(),strlen(DIR_ROOT)));
			$file["ext"] = $node->getExtension();
			$file["size"] = $node->getSize();
			$file["date"] = date("d. m. Y G:i:s",$node->getMTime());
			switch($node->getExtension()){
				case "xls":
				case "xlsx":
					$file["imageCssClass"] = 'fa fa-file-excel-o';
				break;
				case "doc":
				case "docx":
					$file["imageCssClass"] = 'fa fa-file-word-o';
				break;
				case "pdf":
					$file["imageCssClass"] = 'fa fa-file-pdf-o';
				break;
				default:
					$file["imageCssClass"] = 'fa fa-file';
			}
			return $file;
	}

	public function actionDownload($name){
		if (strpos($name, '..') === false) {
    // ".." was NOT found
			$this->sendResponse(new FileResponse(DIR_ROOT.$name));
		}
	}
	public function handleChangeFolder($dir)
	{
		$this->template->dir = $dir;
			//$this->getFiles(DIR_ROOT.$dir);
			if ($this->isAjax()) {
					$this->redrawControl('listing');
			}
	}
		public function handleFind($dir)
	{
		$this->template->dir = $dir;
			if ($this->isAjax()) {
					$this->redrawControl('listing');
			}
	}
}
