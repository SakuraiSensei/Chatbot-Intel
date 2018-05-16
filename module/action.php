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

	if(strpos(strtolower($tempPrint1), strtolower("year 1")) !== false)
	{
		$tempPrint2 = "&#13;&#10;ChatBot Intel: ". "Year 1 papers are, COMM501 Applied Communication, COMP500 Programming 1, COMP501 Computing Technology in Society, COMP502 Foundations of IT Infrastructure, COMP503 Programming 2, ENEL504 Computer Network Principles, INFS500 Enterprise Systems and chosoe one of MATH500 Mathematical Concepts, MATH501 Differential and Integral Calculus, MATH502 Algebra and Discrete Mathematics, and STAT500 Applied Statistics.";
	}
	else if(strpos(strtolower($tempPrint1), strtolower("year 2")) !== false)
	{
		$tempPrint2 = "&#13;&#10;ChatBot Intel: ". "Year 2 papers are, COMP600 IT Project Management, COMP602 Software Development Practice, COMP603 Program Design and Construction, INFS600 Data and Process Modelling, INFS601 Logical Database Design and choose one of COMP604 Operating Systems and INFS602 Physical Database Design.";
	}
	else if(strpos(strtolower($tempPrint1), strtolower("year 3")) !== false)
	{
		$tempPrint2 = "&#13;&#10;ChatBot Intel: ". "COMP704 Research and Development Project, COMP719 Applied Human Computer, ENSE701 Contemporary Methods in Software Engineering and choose one of COMP713 Distributed and Mobile Systems, and COMP721 Web Development. And choose 45 points from elective papers below or other Bachelor of Computer and Information Sciences papers";
	}
	else
	{
		$tempPrint2 = "&#13;&#10;ChatBot Intel: ". "Thank you for your cooperation. Unfortunately, I cannot understand what you say.";
	}

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