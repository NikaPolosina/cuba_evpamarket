<?php
	
	echo "<pre>";
		$a = curl_init(); 
		var_dump($a);
		
		$b = mcrypt_module_open('rijndael-128', '', 'cbc', '');
		var_dump($b);

		//$memcache = new Memcache;
		//$c = @$memcache->connect('localhost');
		//var_dump($memcache);
		
	echo "</pre>";
	
	phpinfo();
	
	die('die');
?>