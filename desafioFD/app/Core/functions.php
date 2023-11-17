<?php 

function show($stuff)
{
	echo "<pre>";
	print_r($stuff);
	echo "</pre>";
}

function esc($str)
{
	return htmlspecialchars($str);
}

function redirect($path)
{
	header("Location: " . ROOT."/".$path);
	die;
}


function old_value(string $key, $default = "", string $mode = 'post')
{
  $POST = ($mode == 'post') ? $_POST : $_GET;
  if(isset($POST[$key])) {
    return $POST[$key];
  }

  return $default;
}