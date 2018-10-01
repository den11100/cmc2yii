<?php

namespace app\controllers;

use app\models\Cctx;
use app\models\CctxSearch;
use app\models\State;
use ccxt\Exchange;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Command;
use yii\db\Connection;
use yii\db\Exception;
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

    public function actionUpdate()
    {
        #include __DIR__ . "/../components/ccxt-parser/parser.php";

        $parser = new \Parser();
        $parser::update();

        $exchanges = $parser::get_exchanges();

        VarDumper::dump($exchanges,5,1);
        die();
    }

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
}
