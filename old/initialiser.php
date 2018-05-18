<?php
require_once __DIR__ . './../phpml/vendor/autoload.php';

use Phpml\Classification\MLPClassifier;
use Phpml\NeuralNetwork\ActivationFunction\Sigmoid;
use Phpml\ModelManager;

$year1 = 'Year 1 papers are, COMM501 Applied Communication, COMP500 Programming 1, COMP501 Computing Technology in Society, COMP502 Foundations of IT Infrastructure, COMP503 Programming 2, ENEL504 Computer Network Principles, INFS500 Enterprise Systems and chosoe one of MATH500 Mathematical Concepts, MATH501 Differential and Integral Calculus, MATH502 Algebra and Discrete Mathematics, and STAT500 Applied Statistics.';

$year2 = 'Year 2 papers are, COMP600 IT Project Management, COMP602 Software Development Practice, COMP603 Program Design and Construction, INFS600 Data and Process Modelling, INFS601 Logical Database Design and choose one of COMP604 Operating Systems and INFS602 Physical Database Design.';

$year3 = 'Year 3 papers are, COMP704 Research and Development Project, COMP719 Applied Human Computer, ENSE701 Contemporary Methods in Software Engineering and choose one of COMP713 Distributed and Mobile Systems, and COMP721 Web Development. And choose 45 points from elective papers below or other Bachelor of Computer and Information Sciences papers.';

$temp = 'I am not sure.';

$array[0] = $year1;
$array[1] = $year2;
$array[2] = $year3;
$array[3] = $temp;

$mlp = new MLPClassifier(4, [[1, new Sigmoid]], [$year1, $year2, $year3, $temp]);

$mlp->train(
    $samples = [[-1, -1, -1, -1]],
    $targets = ['I am not sure.']
);

$filepath = './save';
$modelManager = new ModelManager();
$modelManager->saveToFile($mlp, $filepath);
?>
DONE