<?php

namespace backend\controllers;

use common\models\UmbralesConfiguracion;
use backend\models\search\UmbralesConfiguracionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UmbralesConfiguracionController implements the CRUD actions for UmbralesConfiguracion model.
 */
class UmbralesConfiguracionController extends Controller
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
     * Lists all UmbralesConfiguracion models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UmbralesConfiguracionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UmbralesConfiguracion model.
     * @param int $id_configuracion Id Configuracion
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_configuracion)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_configuracion),
        ]);
    }

    /**
     * Creates a new UmbralesConfiguracion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new UmbralesConfiguracion();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_configuracion' => $model->id_configuracion]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UmbralesConfiguracion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_configuracion Id Configuracion
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_configuracion)
    {
        $model = $this->findModel($id_configuracion);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_configuracion' => $model->id_configuracion]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UmbralesConfiguracion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_configuracion Id Configuracion
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_configuracion)
    {
        $this->findModel($id_configuracion)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UmbralesConfiguracion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_configuracion Id Configuracion
     * @return UmbralesConfiguracion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_configuracion)
    {
        if (($model = UmbralesConfiguracion::findOne(['id_configuracion' => $id_configuracion])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
