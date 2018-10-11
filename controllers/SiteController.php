<?php

namespace app\controllers;

use app\models\Cctx;
use app\models\CctxSearch;
use app\models\Help;
use app\models\LeadersHelp;
use app\models\MarketCap;
use app\models\MarketHelp;
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
            ->andWhere(['NOT LIKE', 'symbol', 'FORTYTWO',])
            ->andWhere(['>', 'last', 0])
            ->groupBy('symbol')
            ->orderBy('timestamp desc')
            ->createCommand()
            ->queryAll();
        $idArr = [];
        foreach ($result as $id){ $idArr[] = $id['id'];}

        $query = Cctx::find()->where(['in', 'id', $idArr])->orderBy('last desc');

        $models = $query->all();

        $newModels = [];
        foreach ($models as $model){
            $symbol = str_replace(['/USDT', '/USDC', '/USD'], '', $model->symbol);
            $newModels[$symbol][] = $model;
        }

        $finalModels = [];
        foreach ($newModels as $symbol => $models){
            if (count($models) > 1){
                $prices = 0;
                foreach ($models as $model){
                    $prices += $model->last;
                    $lastModel = $model;
                }
                $price = $prices/count($models);
                $lastModel->last = $price;
                $finalModels[$symbol] = $lastModel;
                if ($symbol == 'BTC') Cctx::$BTC_CURRENT = $lastModel->last;
            } else {
                $finalModels[$symbol] = $models[0];
                if ($symbol == 'BTC') Cctx::$BTC_CURRENT = $models[0]->last;
            }
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $finalModels,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $marketCap = MarketCap::find()->asArray()->all();
        $marketCapFinal = ArrayHelper::map($marketCap, 'symbol', 'market_cap');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'marketCapFinal' => $marketCapFinal,
        ]);
    }

    public function actionInfoMarket($symbol)
    {
        $symbol = strtoupper($symbol);
        /* находим id записей максимально близкие к now но не старше X дней*/
        $array = State::find()
            ->where(new Expression('timestamp BETWEEN UNIX_TIMESTAMP(NOW() - INTERVAL 200 DAY)*1000 AND UNIX_TIMESTAMP(NOW())*1000'))
            ->andWhere(['interval' => "1d"])
            ->andWhere(['market' => $symbol.'/USDT'])
            ->orderBy('timestamp asc')
            ->asArray()
            ->all();

        $idRowTimestampLessToNow = ArrayHelper::getColumn($array,'id');
        $list = State::find()
            ->select('timestamp, avg(open) as avg_open, avg(high) as avg_high, avg(low) as avg_low,  avg(close) as avg_close, volume')
            ->where(['in', 'id', $idRowTimestampLessToNow])
            ->asArray()
            ->groupBy('timestamp')
            ->all();

        $tickerList = [];
        $volumeList = [];
        foreach ($list as $key => $item) {
            $itemNumbers = [];
            $volumeNumbers = [];
            foreach ($item as $k => $value){
                if ($k == 'volume' || $k == 'timestamp'){
                    $volumeNumbers[$k] = $value*1;
                }
                if ($k != 'volume') {
                    $itemNumbers[$k] = $value*1;
                }
            }
            $tickerList[$key] = array_values($itemNumbers);
            $volumeList[$key] = array_values($volumeNumbers);
        }
        /* --- make pies --- */
        /* Volume .../USD 24h by exchange */
        $modelsGroupByExchange = MarketHelp::getListForPieExchange($symbol);
        $pieExchangeData = MarketHelp::getPieExchangeData($modelsGroupByExchange);

        /* Volume $symbol 24 by currency */
        $modelsGroupByMarket = MarketHelp::getModelsGroupByMarket($symbol);
        $modelsGroupByMarketWithExchange = MarketHelp::getModelsGroupByMarketWithExchange($symbol);
        $markets = MarketHelp::getMarkets($modelsGroupByMarketWithExchange);
        $pieMarketData = MarketHelp::getPieMarketData($modelsGroupByMarket);

        return $this->render('info-market', [
            'symbol' => $symbol,
            'tickerList' => $tickerList,
            'volumeList' => $volumeList,

            'modelsGroupByExchange' => $modelsGroupByExchange,
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
