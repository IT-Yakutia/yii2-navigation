<?php

namespace ityakutia\navigation\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use uraankhayayaal\sortable\behaviors\Sortable;
use yii\behaviors\SluggableBehavior;

class Navigation extends ActiveRecord
{
    public static function tableName()
    {
        return 'navigation';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'sortable' => [
                'class' => Sortable::class,
                'query' => self::find(),
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'immutable' => true,
                'ensureUnique' => true,
            ]
        ];
    }

    public function rules()
    {
        return [
            [['name', 'link'], 'required'],
            [['sort', 'is_publish', 'status', 'created_at', 'updated_at', 'parent_id'], 'integer'],
            [['name', 'link', 'slug'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'link' => 'Link',
            'parent_id' => 'Parent ID',
            'slug' => 'Slug',
            'sort' => 'Sort',
            'is_publish' => 'Is Publish',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getTrees()
    {
        $roots = Navigation::find()->where(['parent_id' => null])->andWhere(['is_publish' => true])->all();
        $root_ids = [];
        $navigation = [];
        foreach ($roots as $root) {
            $root_ids[] = $root->id;
            $navigation[$root->id] = [
                'label' => $root->name,
                'link' => [$root->link, 'slug' => $root->slug]
            ];
        }

        $childs = Navigation::find()->where(['!=', 'parent_id', false])->andWhere(['is_publish' => true])->all();

        foreach($navigation as $parent_id => $nav) {
            foreach($childs as $child) {
                if($parent_id === $child->parent_id) {
                    $navigation[$parent_id]['items'][] = [
                        'label' => $child->name,
                        'link' => [$root->link, 'slug' => $child->slug]
                    ]; 
                }
            }
        } 

        return $navigation;
    }
}
