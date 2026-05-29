<?php

namespace backend\controllers;

use common\models\LecturasSensores;
use backend\models\search\LecturasSensoresSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LecturasSensoresController implements the CRUD actions for LecturasSensores model.
 */
class LecturasSensoresController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all LecturasSensores models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LecturasSensoresSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LecturasSensores model.
     * @param int $id_lectura Id Lectura
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_lectura)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_lectura),
        ]);
    }

    /**
     * Creates a new LecturasSensores model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new LecturasSensores();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_lectura' => $model->id_lectura]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing LecturasSensores model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_lectura Id Lectura
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_lectura)
    {
        $model = $this->findModel($id_lectura);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_lectura' => $model->id_lectura]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LecturasSensores model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_lectura Id Lectura
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_lectura)
    {
        $this->findModel($id_lectura)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LecturasSensores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_lectura Id Lectura
     * @return LecturasSensores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_lectura)
    {
        if (($model = LecturasSensores::findOne(['id_lectura' => $id_lectura])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
