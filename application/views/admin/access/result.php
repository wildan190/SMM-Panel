<pre>
<?php 
	$json = json_decode(json_encode($result), true);
	if (isset($json['user'])) {
		echo 'ada';
	} else {
		echo 'tidak ada';
	}
?>
</pre>