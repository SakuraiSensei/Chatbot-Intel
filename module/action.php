<textarea readonly>
ChatBot Intel: Hello. How can I help you?
<?php
	if ($_SERVER['REQUEST_METHOD'] === 'GET' && htmlspecialchars($_GET['messanger']) != null) {
		echo 'You: '. htmlspecialchars($_GET['messanger']);
		echo '&#13;&#10;ChatBot Intel: '. 'Thank you for your cooperation. cookie.';
	}
?>
</textarea>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && htmlspecialchars($_GET['messanger']) != null) {
	echo "<form action=\"chatform.php\" method=\"get\">";
	echo "<input class=\"input\" name=\"messanger\" type=\"text\" readonly>";
	echo "<input class=\"input-button\" value=\"Submit\" type=\"submit\" readonly>";
}
else
{
	echo "<form action=\"chatform.php\" method=\"get\">";;
	echo "<input class=\"input\" name=\"messanger\" type=\"text\">";
	echo "<input class=\"input-button\" value=\"Submit\" type=\"submit\">";
}
?>

</form>