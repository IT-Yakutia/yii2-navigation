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

    public function search($params)
    {
        $query = Navigation::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['sort' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'color_switcher' => $this->color_switcher,

            'depth' => 0, // Показывать только корни, каждый корень это новое меню
            'sort' => $this->sort,
            'is_publish' => $this->is_publish,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'link', $this->link])
        ;

        return $dataProvider;
    }
}
