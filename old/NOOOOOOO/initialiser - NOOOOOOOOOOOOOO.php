<?php
require_once __DIR__ . './../phpml/vendor/autoload.php';

$myfile = fopen("trainingsample.txt", "r") or die("Unable to open file!");
$data = fread($myfile,filesize("trainingsample.txt"));
//echo str_replace(";", "<BR>", $data);
fclose($myfile);

$data = str_replace("\r\n", "", $data);
$data = str_replace("\n", "", $data);
$datacopy = $data;
$array = ['I am not sure.'];

//Output list creator
while(true)
{
    if(!strpos($datacopy, "Output;"))
	break;

    $cutter = strpos($datacopy, "Output;") + 7;
    $modifiedstr = substr($datacopy, $cutter);
    $modifiedcutter = strpos($modifiedstr, ";");
    array_push($array, substr($modifiedstr, 0, $modifiedcutter));
    $datacopy = substr($datacopy, $cutter);
}

use Phpml\Classification\MLPClassifier;
use Phpml\NeuralNetwork\ActivationFunction\Gaussian;
use Phpml\NeuralNetwork\ActivationFunction\PReLU;
use Phpml\NeuralNetwork\ActivationFunction\Sigmoid;
use Phpml\ModelManager;

$mlp = new MLPClassifier(10, [[3, new PReLU],[3, new Gaussian],[3, new Sigmoid]], $array);

$arrayInput = ['I am not sure.'];
$arrayOutput = ['I am not sure.'];

$datacopy = $data;

$numb = 0;

while(strlen($datacopy) > 1)
{
    $numb = 0;
    $cutter = strpos($datacopy, "Inputs;") + 7;
    $modifiedstr = substr($datacopy, $cutter);
    $modifiedcutter = strpos($modifiedstr, ";");
    array_push($arrayInput, substr($modifiedstr, 0, $modifiedcutter));
    $datacopy = substr($datacopy, $cutter);
    $datacopy = substr($datacopy, strpos($datacopy, ";") + 1);

    while(true)
    {

        if(substr($datacopy, 0, 7) == 'Output;')
            break;

        $cutter = strpos($datacopy, ";") + 1;
        $modifiedstr = substr($datacopy, 0, $cutter - 1);
        array_push($arrayInput, $modifiedstr);
        $datacopy = substr($datacopy, $cutter);
	$numb++;
    }


    $cutter = strpos($datacopy, "Output;") + 7;
    $modifiedstr = substr($datacopy, $cutter);
    $modifiedcutter = strpos($modifiedstr, ";");

    for($i = 0; $i < $numb + 1; $i++)
    {
        array_push($arrayOutput, substr($modifiedstr, 0, $modifiedcutter));
    }

    $datacopy = substr($datacopy, $cutter);
    $cutter = strpos($datacopy, ";");
    $datacopy = substr($datacopy, $cutter + 1);
}

//$arrayInput
//$arrayOutput

$ArrayInputSuper = [-1,-1,-1,-1,-1,-1,-1,-1,-1,-1];
$ArrayInputHyperSuper = [$ArrayInputSuper];

//GOGOGOGO
for($gogo = 1; $gogo < sizeof($arrayInput); $gogo++)
{
	$receivedString = htmlspecialchars($arrayInput[$gogo]);

	$receivedString = str_replace("what", "", $receivedString);
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
	$receivedString = str_replace(" ", "", $receivedString);

	$arr = str_split(strtolower($receivedString));
	$length = strlen($receivedString);

	$x = -1;

	$node = [0,0,0,0,0,0,0,0,0,0];

	while($x++ < 11)
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
				$loopSum = $loopSum * 123;
			}
			
			$node[$x] += $loopSum;
		}
		else if('0' <= $arr[$x] && $arr[$x] <= '9')
		{
			$looper = ord($arr[$x])-21;
			$loopSum = 1;
			$y = -1;

			while($y++ < $looper-2)
			{
				$loopSum = $loopSum * 123;
			}
			
			$node[$x] += $loopSum;
		}
	}

$ArrayInputSuper = $node;

//ENDENDEND

array_push($ArrayInputHyperSuper, $ArrayInputSuper);
}

echo sizeof($ArrayInputHyperSuper);
echo sizeof($arrayOutput);

echo print_r($ArrayInputHyperSuper);

$mlp->train(
    $samples = $ArrayInputHyperSuper,
    $targets = $arrayOutput
);

$tempPrint2 = $mlp->predict($ArrayInputHyperSuper);

echo print_r($tempPrint2);

$filepath = './saves';
$modelManager = new ModelManager();
$modelManager->saveToFile($mlp, $filepath);
?>
DONES