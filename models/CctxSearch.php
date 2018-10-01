<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cctx;

/**
 * CctxSearch represents the model behind the search form of `app\models\Cctx`.
 */
class CctxSearch extends Cctx
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'timestamp'], 'integer'],
            [['exchange', 'symbol'], 'safe'],
            [['last'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Cctx::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'last' => $this->last,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'exchange', $this->exchange])
            ->andFilterWhere(['like', 'symbol', $this->symbol]);

        return $dataProvider;
    }
}
