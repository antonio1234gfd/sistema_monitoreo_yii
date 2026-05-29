<?php

namespace backend\controllers;

use common\models\Dispositivos;
use backend\models\search\DispositivosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DispositivosController implements the CRUD actions for Dispositivos model.
 */
class DispositivosController extends Controller
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
     * Lists all Dispositivos models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DispositivosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dispositivos model.
     * @param int $id_dispositivo Id Dispositivo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_dispositivo)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_dispositivo),
        ]);
    }

    /**
     * Creates a new Dispositivos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Dispositivos();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_dispositivo' => $model->id_dispositivo]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Dispositivos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_dispositivo Id Dispositivo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_dispositivo)
    {
        $model = $this->findModel($id_dispositivo);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_dispositivo' => $model->id_dispositivo]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Dispositivos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_dispositivo Id Dispositivo
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_dispositivo)
    {
        $this->findModel($id_dispositivo)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dispositivos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_dispositivo Id Dispositivo
     * @return Dispositivos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_dispositivo)
    {
        if (($model = Dispositivos::findOne(['id_dispositivo' => $id_dispositivo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
