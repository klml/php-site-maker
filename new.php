<?php
/*
 * @name new.php
 * @class NewPage
 * @param $args = array('0' => type, '2' => name);
 * @description create a post markdown page or a page markdown page
 * @auther 2dkun
 */

require_once '_src/Spyc.php';
require_once '_src/Tools.php';

class NewPage {

	protected $config;
	protected $filePath;
	
	public function __construct($args) {
		if (!isset($args) || count($args) < 3) {
			err("two parameters are required, like\n- php new.php post hello-world\n- php new.php page about");
			return;
		}
		
		$this->config = spyc_load_file('config.yml');
		$this->filePath = $this->config['path'];
		foreach ($this->filePath as &$fp) {
			$fp = '.' . $fp;
		}
		$this->create($args[1], $args[2]);
	}

	protected function create($type, $title) {
		$date = date('Y-m-d');
		switch ($type) {
			case 'post':
				$filename = "{$this->filePath['post']}/$date-$title.md";
				if (file_exists($filename)) {
					err('post is exists.');
					exit(0);
				}
				$fp = fopen($filename,"w+");
				fputs($fp, "---\n");
				fwrite($fp, "layout: $type\n");
				fwrite($fp, "title: \n");
				fwrite($fp, "category: \n");
				fwrite($fp, "comment: true\n");
				fwrite($fp, "---\n");
				fclose($fp);
				break;

			case 'page':
				$filename = "{$this->filePath['page']}/$title.md";
				if (file_exists($filename)) {
					err('page is exists.');
					exit(0);
				}
				$fp = fopen($filename,"w+");
				fputs($fp, "---\n");
				fwrite($fp, "layout: $type\n");
				fwrite($fp, "name: \n");
				fwrite($fp, "comment: true\n");
				fwrite($fp, "---\n");
				fclose($fp);
				break;

			default:
				return;
		}
		suc("$type is built.");
	}
}

new NewPage($argv);

?>
