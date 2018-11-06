<?php

require "vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;
use Google\Cloud\Language\LanguageClient;

$language = new LanguageClient([
    'projectId' => 'calldrip-dev',
    'keyFilePath' => '/opt/lampp/htdocs/googleservicedev.json'
]);

$connection = new TwitterOAuth('NCRsbohuk10DznHImq8UY9OOK', '6lDZEYjQtntV3XX65iqfk5WUk6HLOurPi88Ebt6lFwPDyjKWwk', '1059833903286910977-O0YedZohxiLVH2RpfP1qH6cGoFxKYm', 'LbDDM3WkXtD7buL2BFPGDW8f20zWAvBQhqzi7NAkv4XZb');
$content = $connection -> get("account/verify_credentials");
$tweets = $connection -> get("search/30day", ["q" => $_POST['query']]);

$totalSentimentScore = 0;
$totalMagnitudeScore = 0;
$returnArray = array();
$totalTweets = count($tweets -> statuses);

if($totalTweets == 0) {
    $returnArray['status'] = "No Tweets Found";
} else {
    foreach($tweets -> statuses as $tweet) {
        $annotation = $language -> analyzeSentiment($tweet -> text);
        $sentiment = $annotation -> sentiment();

        $totalSentimentScore += $sentiment['score'];
        $totalMagnitudeScore += $sentiment['magnitude'];
    }

    $returnArray['status'] = 'Tweets Found';
    $returnArray['TotalTweets'] = $totalTweets;
    $returnArray['TotalSentimentScore'] = $totalSentimentScore;
    $returnArray['AverageSentimentScore'] = $totalSentimentScore / $totalTweets;
    $returnArray['TotalMagnitudeScore'] = $totalMagnitudeScore;
    $returnArray['AverageMagnitudeScore'] = $totalMagnitudeScore / $totalTweets;
}

echo json_encode($returnArray);
