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

use Phpml\Classification\MLPClassifier;
use Phpml\NeuralNetwork\ActivationFunction\PReLU;
use Phpml\NeuralNetwork\ActivationFunction\Sigmoid;
use Phpml\NeuralNetwork\ActivationFunction\Gaussian;
use Phpml\NeuralNetwork\ActivationFunction\HyperbolicTangent;
use Phpml\ModelManager;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && htmlspecialchars($_GET['messanger']) != null) {
	$tempPrint1 = "&#13;&#10;You: " . htmlspecialchars($_GET['messanger']);

	$receivedString = htmlspecialchars($_GET['messanger']);

	$arr = str_split(strtolower($receivedString));
	$length = strlen($receivedString);

	$x = -1;

	$node1 = 0;
	$node2 = 0;
	$node3 = 0;
	$node4 = 0;

	while($x++ < $length-1)
	{
		//Sum of all characters and numbers (typo error will be solved automatically)
		//a to z and 0 to 9.
		if('a' <= $arr[$x] && $arr[$x] <= 'z')
		{
			$looper = ord($arr[$x])-96;
			$loopSum = 1;
			$y = -1;

			while($y++ < $looper-2)
			{
				$loopSum = $loopSum * 10;
			}
			
			$node1 += $loopSum;
		}
		else if('0' <= $arr[$x] && $arr[$x] <= '9')
		{
			$looper = ord($arr[$x])-21;
			$loopSum = 1;
			$y = -1;

			while($y++ < $looper-2)
			{
				$loopSum = $loopSum * 10;
			}
			
			$node1 += $loopSum;
		}
	}

	//length of string
	$node2 = $length;

	$output = htmlspecialchars($_GET['output']);

	$filepath = './save';

	$modelManager = new ModelManager();
	$restoredClassifier = $modelManager->restoreFromFile($filepath);
	$mlp = $restoredClassifier;

	$mlp->train(
    		$samples = [[$node1,$node2,$node3,$node4]],
    		$targets = [$output]
	);

	$modelManager->saveToFile($mlp, $filepath);

	$tempPrint2 = $mlp->predict([[$node1,$node2,$node3,$node4]]);

	echo $tempPrint1 . " TEST VALUE: " . $node1;
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
}
?>
</textarea>
<?php
	echo "<form action=\"chatformadmin.php\" method=\"get\">";
	echo "INPUT :::: ";
	echo "<input class=\"input\" name=\"messanger\" type=\"text\">";
	echo "<BR>OUTPUT: ";
	echo "<input class=\"input\" name=\"output\" type=\"text\">";
	echo "<input class=\"input-button\" value=\"Submit\" type=\"submit\">";
?>
</form>