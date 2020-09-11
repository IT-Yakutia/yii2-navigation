<?php

namespace ityakutia\navigation\controllers;

use ityakutia\navigation\models\Navigation;
use ityakutia\navigation\models\NavigationSearch;
use uraankhayayaal\sortable\actions\Sorting;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class BackController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['navigation']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST']
                ]
            ]
        ];
    }

    public function actions()
    {
        return [
            'sorting' => [
                'class' => Sorting::class,
                'query' => Navigation::find(),
            ]
        ];
    }

    public function actionIndex()
    {
        // Показывать только корни, каждый корень это новое меню
        $searchModel = new NavigationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Url::remember();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        // Показывать дочерние элементы корня, и производить действия внутри корня
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    public function actionCreate()
    {
        $model = new Navigation();
        if (!empty(Yii::$app->request->post('Navigation'))) {
            $post = Yii::$app->request->post('Navigation');
            $model->load(Yii::$app->request->post());
            $parent_id = $post['parentId'];

            if (empty($parent_id)) {
                $trees_list = $model->getTreesList();
                if (empty($trees_list)) {
                    $model->tree = 1;
                } else {
                    $max = (int)max($trees_list)['tree'] + 1;
                    $model->tree = $max;
                }
                $model->makeRoot();
            } else {
                $parent = Navigation::findOne($parent_id);
                $model->appendTo($parent);
            }

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (!empty(Yii::$app->request->post('Navigation'))) {

            $post = Yii::$app->request->post('Navigation');
            $model->load(Yii::$app->request->post());
            $parent_id = $post['parentId'];

            if ($model->save()) {
                if (empty($parent_id)) {
                    if (!$model->isRoot())
                        $model->makeRoot();
                } else {
                    if ($model->id != $parent_id) {
                        $parent = Navigation::findOne($parent_id);
                        $model->appendTo($parent);
                    }
                }

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->isRoot()) {

            // Получаю максимальный ID среди ветвей
            $max_tree = (int)max($model->getTreesList())['tree'] + 1;

            // Флаг для слежения за глубиной дочерних элементов
            $local_depth = 0;
            $childs = $model->children()->all();
            foreach ($childs as $child) {
                // Если глубина стала меньше, чем сохранённая локально - началась новая ветвь дерева
                if ($child->depth < $local_depth) {
                    $max_tree++;
                }
                // Каждый раз слежу за глубиной дерева
                $local_depth = $child->depth;
                // Задаю новые пераметры ветвям
                $child->tree = $max_tree;
                $child->depth = $child->depth - 1;
                $child->save();
            }
            // Выше перенёс дочерние элементы на новые деревья, поэтому deleteWithChildren удалит только старый корень
            $model->depth = -1;
            $model->save();
            $model->deleteWithChildren();
        } else {
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        $model = Navigation::findOne($id);
        if (null === $model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }

    public function actionMove()
    {
        $move_node_id = str_replace('navitem_', '', Yii::$app->request->post('move_node_id')); // navitem_<ID>
        $move_mode = Yii::$app->request->post('move_mode'); // 'makeRoot', 'prepend_to', 'append_to', 'insert_before', 'insert_after', 'deleteWithChildren', 'deleteWithChildrenInternal', 
        $terget_node_id = str_replace('navitem_', '', Yii::$app->request->post('terget_node_id'));

        $model = Navigation::find()->where(['id' => $move_node_id])->one();
        $target_node = Navigation::find()->where(['id' => $terget_node_id])->one();
        if ($model === null || $target_node == null) {
            if ($move_mode !== 'makeRoot' && $model !== null) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'type' => 'error',
                    'message' => 'Ошибка при сортировке! Узел или объект не найден',
                ];
            }
        }

        switch ($move_mode) {
            case 'makeRoot':
                $model->makeRoot();
                break;
            case 'prependTo':
                $model->prependTo($target_node);
                break;
            case 'appendTo':
                $model->appendTo($target_node);
                break;
            case 'insertBefore':
                $model->insertBefore($target_node);
                break;
        }

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'type' => 'success',
            'message' => 'Сортировка прошла успешно!',
            'move_node_id' => $move_node_id,
            'move_mode' => $move_mode,
            'terget_node_id' => $terget_node_id,
        ];
    }
}
