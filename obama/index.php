<?php

if (!empty($_POST['url']))
{
	$url = substr($_POST['url'],0,strpos($_POST['url'],"ref=")) . "theobatimcap-20";
	header("Location: {$url}");
}

?>
<html>



<head>





<title>

Against All Odds Productions

</title>





</head>

<body bgcolor="#ffffff">

Paste the Amazon URL into the box below:

<form method="post" action="">

<input type="text" name="url" id="url" size="40" />

<input type="submit" />

</form>

</body>


</html>
