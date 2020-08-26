<?php

namespace ityakutia\navigation\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;
use yii\db\ActiveQuery;

class NavigationQuery extends ActiveQuery
{
    public function behaviors()
    {
        return [
            NestedSetsQueryBehavior::class
        ];
    }

    /**
     * @return Navigation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @return Navigation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}