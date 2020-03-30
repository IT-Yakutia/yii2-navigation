<?php

namespace ityakutia\navigation\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use uraankhayayaal\sortable\behaviors\Sortable;

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
            ]
        ];
    }

    public function rules()
    {
        return [
            [['name', 'link'], 'required'],
            [['sort', 'is_publish', 'status', 'created_at', 'updated_at', 'parent'], 'integer'],
            [['name', 'link'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'link' => 'Link',
            'parent' => 'Parent',
            'sort' => 'Sort',
            'is_publish' => 'Is Publish',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}