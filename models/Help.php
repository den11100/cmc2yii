<?php
/**
 * Created by PhpStorm.
 * User: dn
 * Date: 03.10.18
 * Time: 6:10
 */

namespace app\models;

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
            $sum = array_sum(ArrayHelper::getColumn($models, 'my_sum'));
            foreach ($models as $key => $model) {
                $models[$key]['my_sum'] = round($model['my_sum'], 4);
                $models[$key]['percent'] = round($model['my_sum'] / $sum, 4);
            }
        }

        return $models;
    }
}