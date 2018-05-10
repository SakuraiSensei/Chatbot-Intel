<textarea readonly>
<?php

$temp = null;

if(!isset($_COOKIE["chatBotIntel"])) {
	$temp = 'ChatBot Intel: Hello. How can I help you?';
	setcookie("chatBotIntel", $temp);
	echo $temp;
}
else
{
	echo $_COOKIE["chatBotIntel"];
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && htmlspecialchars($_GET['messanger']) != null) {
	$tempPrint1 = "&#13;&#10;You: " . htmlspecialchars($_GET['messanger']);
	$tempPrint2 = "&#13;&#10;ChatBot Intel: ". "Thank you for your cooperation. cookie.";

	echo $tempPrint1;
	echo $tempPrint2;

	if($temp == null)
	{
		$temp = $_COOKIE["chatBotIntel"];
		setcookie("chatBotIntel", $temp . $tempPrint1 . $tempPrint2);
	}
	else
	{
		setcookie("chatBotIntel", $temp . $tempPrint1 . $tempPrint2);
	}
}
?>
</textarea>
<?php
	echo "<form action=\"chatform.php\" method=\"get\">";
	echo "<input class=\"input\" name=\"messanger\" type=\"text\">";
	echo "<input class=\"input-button\" value=\"Submit\" type=\"submit\">";
?>

</form>