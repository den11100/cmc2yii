<?php
/**
 * Created by PhpStorm.
 * User: dn
 * Date: 03.10.18
 * Time: 6:10
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class Help extends Model
{
    /**
     * @param $models
     * @return mixed
     */
    public static function getPercent($models)
    {
        if($models != []) {
            $sum = array_sum(ArrayHelper::getColumn($models, 'volume'));
            foreach ($models as $key => $model) {
                //$models[$key]['volume'] = round($model['volume'], 4);
                $models[$key]['percent'] = round($model['volume'] / $sum, 4);
            }
        }

        return $models;
    }
}