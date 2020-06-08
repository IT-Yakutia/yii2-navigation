<?php

namespace ityakutia\navigation\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use uraankhayayaal\sortable\behaviors\Sortable;
use Yii;

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
            [['sort', 'is_publish', 'color_switcher', 'status', 'created_at', 'updated_at', 'parent_id'], 'integer'],
            [['name', 'link'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Имя'),
            'link' => Yii::t('app', 'Ссылка'),
            'parent_id' => Yii::t('app', 'Родительская'),
            'color_switcher' => Yii::t('app', 'Переключение цвета'),
            'sort' => Yii::t('app', 'Сортировка'),
            'is_publish' => Yii::t('app', 'Опубликовать'),
            'status' => Yii::t('app', 'Статус'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
        ];
    }

    public function getTrees()
    {
        $roots = Navigation::find()->where(['parent_id' => null])->andWhere(['is_publish' => true])->orderBy(['sort' => SORT_ASC])->all();
        $root_ids = [];
        $navigation = [];
        foreach ($roots as $root) {
            $root_ids[] = $root->id;
            $navigation[$root->id] = [
                'label' => $root->name,
                'url' => $root->link,
                'options' => $root->color_switcher ? ['class' => 'accent'] : null
            ];
        }

        $childs = Navigation::find()->where(['!=', 'parent_id', false])->andWhere(['is_publish' => true])->orderBy(['sort' => SORT_ASC])->all();

        foreach($navigation as $parent_id => $nav) {
            foreach($childs as $child) {
                if($parent_id === $child->parent_id) {
                    $navigation[$parent_id]['items'][] = [
                        'label' => $child->name,
                        'url' => $child->link
                    ]; 
                }
            }
        } 

        return $navigation;
    }

    public function getParentName()
    {   
        return $this->find()->where(['id' => $this->parent_id])->one()->name;
    }
}
