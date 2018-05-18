<textarea readonly>
<?php
session_start();

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
use Phpml\NeuralNetwork\ActivationFunction\ThresholdedReLU;
use Phpml\NeuralNetwork\ActivationFunction\HyperbolicTangent;
use Phpml\NeuralNetwork\ActivationFunction\BinaryStep;
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

	$receivedString = str_replace("what", "", strtolower($receivedString));
	$receivedString = str_replace("why", "", $receivedString);
	$receivedString = str_replace("how", "", $receivedString);
	$receivedString = str_replace("is", "", $receivedString);
	$receivedString = str_replace("are", "", $receivedString);
	$receivedString = str_replace("the", "", $receivedString);
	$receivedString = str_replace("have", "", $receivedString);
	$receivedString = str_replace(" a ", "", $receivedString);
	$receivedString = str_replace("a ", "", $receivedString);
	$receivedString = str_replace(" a", "", $receivedString);
	$receivedString = str_replace("will", "", $receivedString);
	$receivedString = str_replace("would", "", $receivedString);
	$receivedString = str_replace("could", "", $receivedString);
	$receivedString = str_replace("can", "", $receivedString);

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
			
			$node3 += $loopSum;
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
			
			$node3 += $loopSum;
		}
	}

	$length = strlen($receivedString);
	$node4 = $length;

	$output = htmlspecialchars($_GET['output']);

	$filepath = './save';

	$modelManager = new ModelManager();
	$restoredClassifier = $modelManager->restoreFromFile($filepath);
	$mlp = $restoredClassifier;

	$mlp->partialTrain(
    		$samples = [[$node1,$node2,$node3,$node4]],
    		$targets = [$output]
	);

	$modelManager = new ModelManager();
	$modelManager->saveToFile($mlp, $filepath);

	/*
	$tempPrint2 = $mlp->predict([[$node1,$node2,$node3,$node4]]);
	echo $tempPrint1 . $node1 . ' ' . $node2 . ' ' . $node3 . ' ' . $node4;
	echo "&#13;&#10;ChatBot Intel: " . $tempPrint2[0] . " (...PREDICTION FOR TRAINING PURPOSE...)";

	if($temp == null)
	{
		$temp = $_COOKIE["chatBotIntel"];
		setcookie("chatBotIntel", $temp . $tempPrint1 . "&#13;&#10;ChatBot Intel: " . $tempPrint2[0] . " (...PREDICTION FOR TRAINING PURPOSE...)");
	}
	else
	{
		setcookie("chatBotIntel", $temp . $tempPrint1 . "&#13;&#10;ChatBot Intel: " . $tempPrint2[0] . " (...PREDICTION FOR TRAINING PURPOSE...)");
	}
	*/
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