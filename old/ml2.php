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
$year1input2 = 2;
$year2input = 3;
$year3input = 4;

use Phpml\NeuralNetwork\ActivationFunction\PReLU;
use Phpml\NeuralNetwork\ActivationFunction\Sigmoid;
$mlp = new MLPClassifier(1, [[2, new PReLU], [2, new Sigmoid]], [$year1, $year2, $year3]);

$mlp->partialTrain(
    $samples = [[$year1input1], [$year1input2], [$year2input], [$year3input]],
    $targets = [$year1, $year1, $year2, $year3]
);

$data = $mlp->predict([[1]]);

echo $data[0] . '<BR>';

$data = $mlp->predict([[2]]);

echo $data[0] . '<BR>';

$data = $mlp->predict([[3]]);

echo $data[0] . '<BR>';

$data = $mlp->predict([[4]]);

echo $data[0] . '<BR>';
?>
B