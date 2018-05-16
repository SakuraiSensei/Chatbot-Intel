<?php
require_once __DIR__ . '/phpml/vendor/autoload.php';

$year1 = 'year 1 papers are';
$year2 = 'year 2 papers are';
$year3 = 'year 3 papers are';

use Phpml\Classification\MLPClassifier;
$mlp = new MLPClassifier(1, [2], [$year1, $year2, $year3]);

$year1input1 = 100;
$year1input2 = 200;
$year2input = 1;
$year3input = 2;

use Phpml\NeuralNetwork\ActivationFunction\PReLU;
use Phpml\NeuralNetwork\ActivationFunction\Sigmoid;
$mlp = new MLPClassifier(1, [[2, new PReLU], [2, new Sigmoid]], [$year1, $year2, $year3]);

$mlp->train(
    $samples = [[$year1input1], [$year1input2], [$year2input], [$year3input]],
    $targets = [$year1, $year1, $year2, $year3]
);

$data = $mlp->predict([[0], [1]]);

echo $data[0] . '<BR>';
echo $data[1] . '<BR>';
?>
B