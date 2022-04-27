<?php 

	$file_log = 'test-gacela.txt';
	$log_info .= $_POST;
	file_put_contents($file_log, $log_info, FILE_APPEND | LOCK_EX);


?>