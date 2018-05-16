<textarea readonly>
<?php

require_once __DIR__ . '/phpml/vendor/autoload.php';

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

$year1 = 'Year 1 papers are, COMM501 Applied Communication, COMP500 Programming 1, COMP501 Computing Technology in Society, COMP502 Foundations of IT Infrastructure, COMP503 Programming 2, ENEL504 Computer Network Principles, INFS500 Enterprise Systems and chosoe one of MATH500 Mathematical Concepts, MATH501 Differential and Integral Calculus, MATH502 Algebra and Discrete Mathematics, and STAT500 Applied Statistics.';

$year2 = 'Year 2 papers are, COMP600 IT Project Management, COMP602 Software Development Practice, COMP603 Program Design and Construction, INFS600 Data and Process Modelling, INFS601 Logical Database Design and choose one of COMP604 Operating Systems and INFS602 Physical Database Design.';

$year3 = 'Year 3 papers are, COMP704 Research and Development Project, COMP719 Applied Human Computer, ENSE701 Contemporary Methods in Software Engineering and choose one of COMP713 Distributed and Mobile Systems, and COMP721 Web Development. And choose 45 points from elective papers below or other Bachelor of Computer and Information Sciences papers';

use Phpml\Classification\MLPClassifier;
use Phpml\NeuralNetwork\ActivationFunction\PReLU;
use Phpml\NeuralNetwork\ActivationFunction\Sigmoid;
use Phpml\ModelManager;

/*
$filepath = '/path/to/store/the/model';

if($restoredClassifier == null)
	echo 'file is not exist';
*/


$mlp = new MLPClassifier(1, [[2, new PReLU], [2, new Sigmoid]], [$year1, $year2, $year3]);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && htmlspecialchars($_GET['messanger']) != null) {
	$tempPrint1 = "&#13;&#10;You: " . htmlspecialchars($_GET['messanger']);

	$receivedString = htmlspecialchars($_GET['messanger']);

	$node1 = 0;

/*
	$mlp->train(
    		$samples = [[0], [1], [2], [3]],
    		$targets = [$year1, $year1, $year2, $year3]
	);
*/

	$filepath = './save';
	$modelManager = new ModelManager();

/*
	$modelManager->saveToFile($mlp, $filepath);
*/

	$restoredClassifier = $modelManager->restoreFromFile($filepath);
	$mlp = $restoredClassifier;

	$tempPrint2 = $mlp->predict([[$node1]]);

	echo $tempPrint1;
	echo "&#13;&#10;ChatBot Intel: " . $tempPrint2[0];

	if($temp == null)
	{
		$temp = $_COOKIE["chatBotIntel"];
		setcookie("chatBotIntel", $temp . $tempPrint1 . "&#13;&#10;ChatBot Intel: " . $tempPrint2[0]);
	}
	else
	{
		setcookie("chatBotIntel", $temp . $tempPrint1 . "&#13;&#10;ChatBot Intel: " . $tempPrint2[0]);
	}
/*


	$node1 = 0;
	$node2 = 0;
	$node3 = 0;
	$node4 = 0;

	$mlp->train(
    		$samples = ['0', '1', '2', '3'],
    		$targets = ['a', 'b', 'c', 'd']
	);

	$tempPrint2 = $mlp->predict([[0]]);

	echo $tempPrint1;
	echo "&#13;&#10;ChatBot Intel: ". " $tempPrint2[0];

	if($temp == null)
	{
		$temp = $_COOKIE["chatBotIntel"];
		setcookie("chatBotIntel", $temp . $tempPrint1 . $tempPrint2[0]);
	}
	else
	{
		setcookie("chatBotIntel", $temp . $tempPrint1 . $tempPrint2[0]);
	}
*/
}
?>
</textarea>
<?php
	echo "<form action=\"chatformadmin.php\" method=\"get\">";
	echo "<input class=\"input\" name=\"messanger\" type=\"text\">";
	echo "<input class=\"input-button\" value=\"Submit\" type=\"submit\">";
?>
</form>