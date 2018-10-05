<?php

namespace app\controllers;

use app\models\Cctx;
use app\models\CctxSearch;
use app\models\Help;
use app\models\LeadersHelp;
use app\models\State;
use app\models\StateTest;
use ccxt\Exchange;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Command;
use yii\db\Connection;
use yii\db\Exception;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    //TODO зачем этот метод ?
    public function actionUpdate()
    {
        #include __DIR__ . "/../components/ccxt-parser/parser.php";

        $parser = new \Parser();
        $parser::update();

        $exchanges = $parser::get_exchanges();

        VarDumper::dump($exchanges,5,1);
        die();
    }

    //TODO зачем этот метод ?
    public function actionUpdateTm()
    {
        #include __DIR__ . "/../components/ccxt-parser/parser.php";

        $parser = new \Parser();

        $parser::update_tm();

        die();
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        State::prepareStates();

        $result = Cctx::find()
            ->select('id')
            ->where(['LIKE', 'symbol', '/USD',])
            ->andWhere(['>', 'last', 0])
            ->groupBy('symbol')
            ->orderBy('timestamp desc')
            ->createCommand()
            ->queryAll();
        $idArr = [];
        foreach ($result as $id){ $idArr[] = $id['id'];}

        $query = Cctx::find()->where(['in', 'id', $idArr])->orderBy('last desc');

        $models = $query->all();

        $symbols = [];
        foreach ($models as $model){
            $symbols[] = str_replace(['/USDT', '/USD'], '', $model->symbol);
        }

        $dataProvider = new ArrayDataProvider([
            'models' => $models,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInfoPair($symbol)
    {
        $symbol = strtoupper($symbol);

        $modelsGroupByExchange = Yii::$app->db->createCommand('SELECT * FROM {{%state}} z1  
            INNER JOIN (SELECT MAX(id) AS id FROM {{%state}} WHERE market LIKE :symbol AND `interval` = "1d" GROUP BY exchange) AS z2 
            ON (z1.id = z2.id)
            ')->bindValue(':symbol', $symbol . '/USD%')
            ->queryAll();
        //VarDumper::dump($modelsGroupByExchange,7,1);die;

        $pieExchangeData = '';
        if ($modelsGroupByExchange != []) {
            /* добавляем в массив моделей в каждую модель свойство percent */
            $modelsGroupByExchange = Help::getPercent($modelsGroupByExchange);

            //{name:'ACX', y:0.1767}, {name:'Binance', y:0.2744}, {name:'HitBTC', y:0.5488}
            foreach ($modelsGroupByExchange as $model) {
                $pieExchangeData .= '{name:\'' . $model['exchange'] . '\',y:' . $model['percent']. '},';
            }
        }


        $modelsGroupByMarket = Yii::$app->db->createCommand('SELECT SUM(volume) as volume, market FROM (
            SELECT * FROM {{%state}} z1  
            INNER JOIN (SELECT MAX(id) AS ids FROM {{%state}} WHERE market LIKE :symbol AND `interval` = "1d" GROUP BY market, exchange) AS z2 
            ON (z1.id = z2.ids)) AS x GROUP BY market
            ')->bindValue(':symbol', $symbol .'/%')
            ->queryAll();

        $modelsGroupByMarketWithExchange = Yii::$app->db->createCommand('
            SELECT * FROM {{%state}} z1  
            INNER JOIN (SELECT MAX(id) AS ids FROM {{%state}} WHERE market LIKE :symbol AND `interval` = "1d" GROUP BY market, exchange) AS z2 
            ON (z1.id = z2.ids)
            ')->bindValue(':symbol', $symbol .'/%')
            ->queryAll();

        $markets = [];
        if($modelsGroupByMarketWithExchange != []) {
            foreach ($modelsGroupByMarketWithExchange as $key => $item) {
                $markets[$item['market']][$key]['high'] = $item['high'];
                $markets[$item['market']][$key]['low'] = $item['low'];
                $markets[$item['market']][$key]['volume'] = $item['volume'];
                $markets[$item['market']][$key]['market'] = $item['market'];
                $markets[$item['market']][$key]['exchange'] = $item['exchange'];
                $markets[$item['market']][$key]['timestamp'] = $item['timestamp'];
                $markets[$item['market']][$key]['interval'] = $item['interval'];
            }
            //VarDumper::dump($modelsGroupByMarketWithExchange,7,1);
            //VarDumper::dump($result,7,1);die;
        }

        $pieMarketData = '';
        if ($modelsGroupByMarket != []) {
            /* добавляем в массив моделей в каждую модель свойство percent */
            $modelsGroupByMarket = Help::getPercent($modelsGroupByMarket);

            //{name:'BTC/USD', y:0.1767}, {name:'BTC/USDT', y:0.2744}, {name:'BTC/USDC', y:0.5488}
            foreach ($modelsGroupByMarket as $model) {
                $pieMarketData .= '{name:\'' . $model['market'] . '\',y:' . $model['percent']. '},';
            }
        }

        return $this->render('info-pair', [
            'modelsGroupByExchange' => $modelsGroupByExchange,
            'symbol' => $symbol,
            'pieExchangeData' => $pieExchangeData,
            'modelsGroupByMarket' => $modelsGroupByMarket,
            'markets' => $markets,
            'pieMarketData' => $pieMarketData,
        ]);
    }

    public function actionInfoLeaders()
    {
        $listLeaders = LeadersHelp::getLeaders();

        $listLeadersGrow = [];
        $listLeadersFall = [];

        if ($listLeaders != []) {
            $listLeadersGrow = LeadersHelp::getLeadersGrow($listLeaders, Yii::$app->params['number-of-leaders']);
            $listLeadersFall = LeadersHelp::getLeadersFall($listLeaders, Yii::$app->params['number-of-leaders']);
        }

        return $this->render('info-leaders', [
            'listLeadersGrow' => $listLeadersGrow,
            'listLeadersFall' => $listLeadersFall,
        ]);
    }

}
