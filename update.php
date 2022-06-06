<?php

function download($file_source, $file_target, $headers)
{
	$opts = array(
		'http'=>array(
			'method'=>"GET",
			'header'=>$headers
		)
	);
	$context = stream_context_create($opts);

	$rh = fopen($file_source, 'rb', null, $context);
	$wh = fopen($file_target, 'wb');
	if($rh === false || $wh === false)
	{
		// error reading or opening file
		return false;
	}
	while(!feof($rh))
	{
		if(fwrite($wh, fread($rh, 1024)) === FALSE)
		{
			// 'Download error: Cannot write to file ('.$file_target.')';
			return false;
		}
	}
	fclose($rh);
	fclose($wh);
	// No error
	return TRUE;
}

if(isset($argv))
{
	parse_str(implode('&', array_slice($argv, 1)), $_GET);
}
$prj_id = $_GET['cicd_project_id'];
$gitlaburl = $_GET['gitlaburl'];
$private_token = $_GET['private_token'];
$files = json_decode($_GET['files']);
$dist_dir = $_GET['dist_dir'];

if(!$dist_dir)
{
	$dist_dir = __DIR__;
}

echo ' gitlaburl=' . $gitlaburl . "\n";

foreach ($files as $file)
{
	echo 'download "' . $file . '", with private key "' . $private_token . '"' . "\n";
	download(
		$gitlaburl . 'api/v4/projects/' . $prj_id . '/repository/files/' . urlencode($file) . '/raw?ref=master',
		$dist_dir . '/' . $file,
		"PRIVATE-TOKEN: " . $private_token . "\r\n");
	echo ' - download "' . $file . '" done!' . "\n";
}
