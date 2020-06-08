<?php

namespace ityakutia\navigation\controllers;

use ityakutia\navigation\models\Navigation;
use ityakutia\navigation\models\NavigationSearch;
use uraankhayayaal\sortable\actions\Sorting;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BackSubController extends Controller
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

    public function actionCreate($parent)
    {
        $model = new Navigation();

        $post = Yii::$app->request->post();
        $load = $model->load($post);
        $model->parent_id = $parent;

        if ($load && $model->save()) {
            Yii::$app->session->setFlash('success', 'Запись успешно создана!');
            return $this->redirect(['back/update', 'id' => $parent]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $searchModel = new NavigationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $post = Yii::$app->request->post();
        $load = $model->load($post);

        if ($load && $model->save()) {
            Yii::$app->session->setFlash('success', 'Запись успешно изменена!');
            return $this->redirect(['back/update', 'id' => $model->parent_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $parent = $model->parent_id;
        if (false !== $model->delete()) {
            Yii::$app->session->setFlash('success', 'Запись успешно удалена!');
        }

        return $this->redirect(['back/update', 'id' => $parent]);
    }

    protected function findModel($id)
    {
        $model = Navigation::findOne($id);
        if (null === $model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }
}
