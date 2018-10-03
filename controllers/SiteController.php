<?php

namespace app\controllers;

use app\models\Cctx;
use app\models\CctxSearch;
use app\models\Help;
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
        //TODO переделать запрос
//        $modelsGroupByExchange = Yii::$app->db->createCommand('SELECT
//              s.volume,
//              s.market,
//              s.exchange,
//              s.timestamp,
//              s.volume - (SELECT x.volume, x.timestamp FROM {{%state-test}} as x WHERE x.timestamp > s.timestamp AND x.exchange = s.exchange LIMIT 1) as result_volume
//                FROM {{%state-test}} as s WHERE s.market LIKE :symbol AND s.timestamp >= UNIX_TIMESTAMP(NOW() - INTERVAL 1 DAY) GROUP BY s.exchange
//                ')
//            ->bindValue(':symbol', $symbol . '/USD')
//            ->queryAll();

//        $modelsGroupByExchange =  StateTest::find()
//            ->select('volume, market, exchange, timestamp')
//            ->where(['LIKE', 'market', $symbol. '/USD'])
//            ->andWhere(['<=', 'timestamp', new Expression('UNIX_TIMESTAMP(NOW())')])
//            ->orderBy('exchange asc')
//            ->groupBy('exchange')
//            ->asArray()
//            ->all();
//
//        VarDumper::dump($modelsGroupByExchange,7,1);die;

        $modelsGroupByExchange = State::find()
            ->select('sum(volume) my_sum, market, exchange, timestamp')
            ->where(['LIKE', 'market', $symbol. '/USD'])
            ->andWhere(['>=', 'timestamp', new Expression('UNIX_TIMESTAMP(NOW() - INTERVAL 1 DAY)')])
            ->orderBy('timestamp desc')
            ->groupBy('exchange')
            ->asArray()
            ->all();

        $pieExchangeData = '';
        if ($modelsGroupByExchange != []) {
            /* добавляем в массив моделей в каждую модель свойство percent */
            $modelsGroupByExchange = Help::getPercent($modelsGroupByExchange);

            //{name:'ACX', y:0.1767}, {name:'Binance', y:0.2744}, {name:'HitBTC', y:0.5488}
            foreach ($modelsGroupByExchange as $model) {
                $pieExchangeData .= '{name:\'' . $model['exchange'] . '\',y:' . $model['percent']. '},';
            }
        }

        return $this->render('info-pair', [
            'modelsGroupByExchange' => $modelsGroupByExchange,
            'symbol' => $symbol,
            'pieExchangeData' => $pieExchangeData,
        ]);
    }

}
