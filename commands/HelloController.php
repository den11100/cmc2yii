<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\MarketCap;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\httpclient\Client;


/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    public function actionStates($interval)
    {
        include __DIR__ . "/../components/ccxt-parser/parser.php";

        $parser = new \Parser();

        $parser::update_tm($interval);
    }

    public function actionMarketCap()
    {
        $url = "https://api.coinmarketcap.com/v2/ticker/";
        $marketCapArray = [];

        $client = new Client();

        $requests = [
            'send1' => $client->get($url.'?start=1&limit=100&sort=id'),
            'send2' => $client->get($url.'?start=101&limit=100&sort=id'),
            'send3' => $client->get($url.'?start=201&limit=100&sort=id'),
            'send4' => $client->get($url.'?start=301&limit=100&sort=id'),
            'send5' => $client->get($url.'?start=401&limit=100&sort=id'),
            'send6' => $client->get($url.'?start=501&limit=100&sort=id'),
            'send7' => $client->get($url.'?start=601&limit=100&sort=id'),
            'send8' => $client->get($url.'?start=701&limit=100&sort=id'),
            'send9' => $client->get($url.'?start=801&limit=100&sort=id'),
            'send10' => $client->get($url.'?start=901&limit=100&sort=id'),
            'send11' => $client->get($url.'?start=1001&limit=100&sort=id'),
        ];

        $responses = $client->batchSend($requests);

        $marketCapArray[1] = json_decode($responses['send1']->content, true);
        $marketCapArray[2] = json_decode($responses['send2']->content, true);
        $marketCapArray[3] = json_decode($responses['send3']->content, true);
        $marketCapArray[4] = json_decode($responses['send4']->content, true);
        $marketCapArray[5] = json_decode($responses['send5']->content, true);
        $marketCapArray[6] = json_decode($responses['send6']->content, true);
        $marketCapArray[7] = json_decode($responses['send7']->content, true);
        $marketCapArray[8] = json_decode($responses['send8']->content, true);
        $marketCapArray[9] = json_decode($responses['send9']->content, true);
        $marketCapArray[10] = json_decode($responses['send10']->content, true);
        $marketCapArray[11] = json_decode($responses['send11']->content, true);

        MarketCap::saveMarketCup($marketCapArray);
    }
}
