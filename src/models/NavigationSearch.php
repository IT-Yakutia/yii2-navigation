<?php

namespace ityakutia\navigation\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class NavigationSearch extends Navigation
{
    public function rules()
    {
        return [
            [['id', 'sort', 'is_publish', 'status', 'created_at', 'updated_at', 'parent_id', 'color_switcher'], 'integer'],
            [['name', 'parent_id', 'link'], 'safe']
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params, $parent = null)
    {
        if (empty($parent)) {
            $query = Navigation::find()->where(['parent_id' => null]);
        } else {
            $query = Navigation::find()->where(['parent_id' => $parent]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['sort' => SORT_ASC]],
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sort' => $this->sort,
            'is_publish' => $this->is_publish,
            'color_switcher' => $this->color_switcher,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])->andFilterWhere(['like', 'link', $this->link]);

        return $dataProvider;
    }
}
