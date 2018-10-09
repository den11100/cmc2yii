<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Help;
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
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        include __DIR__ . "/../components/ccxt-parser/parser.php";

        $parser = new \Parser();
        $parser::update();

        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionStates($interval)
    {
        include __DIR__ . "/../components/ccxt-parser/parser.php";

        $parser = new \Parser();

        $parser::update_tm($interval);
    }

    public function actionMarketCap()
    {
        //https://api.coinmarketcap.com/v2/ticker/?start=101&limit=100&sort=id
        $url = "https://api.coinmarketcap.com/v2/ticker/";
        $start = ['1','101', '201', '301' ,'401', '501'];
        $marketCapArray = [];
        for ($i=0; $i <= 5; $i++) {
            $url = $url . "?start=$start[$i]&limit=100&sort=id";
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('get')
                ->setUrl($url)
                ->send();
            $marketCapArray[$i] = json_decode($response->content, true);
            sleep(1);
        }

        Help::saveDb($marketCapArray);
        //file_put_contents("/var/www/crypto/web/market-cap.txt", json_encode($marketCapArray));
    }
}
