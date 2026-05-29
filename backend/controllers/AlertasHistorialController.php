<?php

namespace backend\controllers;

use common\models\AlertasHistorial;
use backend\models\search\AlertasHistorialSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AlertasHistorialController implements the CRUD actions for AlertasHistorial model.
 */
class AlertasHistorialController extends Controller
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
     * Lists all AlertasHistorial models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AlertasHistorialSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AlertasHistorial model.
     * @param int $id_alerta Id Alerta
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_alerta)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_alerta),
        ]);
    }

    /**
     * Creates a new AlertasHistorial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new AlertasHistorial();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_alerta' => $model->id_alerta]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AlertasHistorial model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_alerta Id Alerta
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_alerta)
    {
        $model = $this->findModel($id_alerta);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_alerta' => $model->id_alerta]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AlertasHistorial model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_alerta Id Alerta
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_alerta)
    {
        $this->findModel($id_alerta)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AlertasHistorial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_alerta Id Alerta
     * @return AlertasHistorial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_alerta)
    {
        if (($model = AlertasHistorial::findOne(['id_alerta' => $id_alerta])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
