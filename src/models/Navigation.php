<?php

namespace ityakutia\navigation\models;

use creocoder\nestedsets\NestedSetsBehavior;
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
            ],
            'tree' => [
                'class' => NestedSetsBehavior::class,
                'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new NavigationQuery(get_called_class());
    }

    public function rules()
    {
        return [
            [['name', 'link'], 'required'],
            [['position'], 'default', 'value' => 0],
            [['tree', 'sort', 'lft', 'rgt', 'depth', 'position', 'is_publish', 'color_switcher', 'status', 'created_at', 'updated_at', 'parent_id'], 'integer'],
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

            'tree' => 'Иерархия',
            'lft' => 'Left',
            'rgt' => 'Right',
            'depth' => 'Depth',
            'position' => 'Позиция в списке',

            'sort' => Yii::t('app', 'Сортировка'),
            'is_publish' => Yii::t('app', 'Опубликовать'),
            'status' => Yii::t('app', 'Статус'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
        ];
    }

    /**
     * Get parent's ID
     * @return \yii\db\ActiveQuery 
     */
    public function getParentId()
    {
        $parent = $this->parent;
        return $parent ? $parent->id : null;
    }

    /**
     * Get parent's node
     * @return \yii\db\ActiveQuery 
     */
    public function getParent()
    {
        return $this->parents(1)->one();
    }

    /**
     * Get a full tree as a list, except the node and its children
     * @param  integer $node_id node's ID
     * @return array array of node
     */
    public static function getTree($node_id = 0)
    {
        // don't include children and the node
        $children = [];

        if (!empty($node_id))
            $children = array_merge(
                self::findOne($node_id)->children()->column(),
                [$node_id]
            );

        $rows = self::find()
            ->select('id, name, depth')
            ->where(['NOT IN', 'id', $children])
            ->orderBy('tree, lft, position')
            ->all();

        $return = [];
        foreach ($rows as $row){
            $return[$row->id]['depth'] = $row->depth;
            $return[$row->id]['name'] = $row->name;
            //$return[$row->id] = str_repeat('-', $row->depth) . ' ' . $row->name;
        }

        return $return;
    }

    public function getTreesList()
    {
        return $this->find()->select('tree')->asArray()->all();
    }

    public static function getNodes($node_id = 0)
    {
        // don't include children and the node
        $children = [];

        if (!empty($node_id))
            $children = array_merge(
                self::findOne($node_id)->children()->column(),
                [$node_id]
            );

        $rows = self::find()
            ->select('id, name, depth')
            ->where(['NOT IN', 'id', $children])
            ->orderBy('tree, lft, position')
            ->all();

        $return = [];
        foreach ($rows as $row){
            $return[$row->id] = str_repeat('-', $row->depth) . ' ' . $row->name;
        }

        return $return;
    }
}
