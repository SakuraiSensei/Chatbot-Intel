A
<?php
require_once __DIR__ . './../phpml/vendor/autoload.php';

$year1 = '1';
$year2 = '2';
$year3 = '3';

use Phpml\Classification\MLPClassifier;
use Phpml\ModelManager;
$mlp = new MLPClassifier(1, [2], [$year1, $year2, $year3]);

$year1input1 = 1;
$year1input2 = 0;
$year2input = 0;
$year3input = 0;

use Phpml\NeuralNetwork\ActivationFunction\PReLU;
use Phpml\NeuralNetwork\ActivationFunction\Sigmoid;
$mlp = new MLPClassifier(4, [[2, new PReLU], [2, new Sigmoid]], [$year1, $year2, $year3]);

$mlp->partialTrain(
    $samples = [[5,10,15,20], [$year1input2,0,0,0], [$year2input,0,0,0], [$year3input,0,0,0]],
    $targets = [$year1, $year1, $year2, $year3]
);

$mlp = new MLPClassifier(4, [[2, new PReLU], [2, new Sigmoid]], [$year1, $year2, $year3]);

$mlp->partialTrain(
    $samples = [[0,0,0,0], [$year1input2,0,0,0], [$year2input,0,0,0], [$year3input,10,0,0]],
    $targets = [$year1, $year1, $year2, $year3]
);

$data = $mlp->predict([[5,10,15,20]]);

echo $data[0] . '<BR>';

$data = $mlp->predict([[0,0,0,0]]);

echo $data[0] . '<BR>';

$data = $mlp->predict([[1,2,3,4]]);

echo $data[0] . '<BR>';

$data = $mlp->predict([[8,0,0,0]]);

echo $data[0] . '<BR>';
?>
B