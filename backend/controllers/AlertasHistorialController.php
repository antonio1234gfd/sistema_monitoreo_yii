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
                        'delete'              => ['POST'],
                        'marcar-leida'        => ['POST'],
                        'marcar-todas-leidas' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all AlertasHistorial models.
     */
    public function actionIndex()
    {
        $searchModel  = new AlertasHistorialSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AlertasHistorial model.
     */
    public function actionView($id_alerta)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_alerta),
        ]);
    }

    /**
     * Creates a new AlertasHistorial model.
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
     */
    public function actionDelete($id_alerta)
    {
        $this->findModel($id_alerta)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Marca una alerta como leída y apaga el buzzer del dispositivo.
     */
    public function actionMarcarLeida($id_alerta)
    {
        $alerta = $this->findModel($id_alerta);

        if (!$alerta->leida_por_usuario) {
            $alerta->leida_por_usuario = 1;
            $alerta->save(false);

            // Apagar buzzer del dispositivo
            if ($alerta->id_dispositivo) {
                \Yii::$app->db->createCommand('
                    UPDATE estado_actuadores
                    SET    buzzer_activo  = 0,
                           modo_operacion = :modo
                    WHERE  id_dispositivo = :id
                ', [
                    ':id'   => $alerta->id_dispositivo,
                    ':modo' => 'MANUAL',
                ])->execute();
            }

            \Yii::$app->session->setFlash('success', 'Alerta #' . $id_alerta . ' marcada como leída y buzzer apagado.');
        } else {
            \Yii::$app->session->setFlash('info', 'Esta alerta ya había sido leída.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Marca TODAS las alertas pendientes como leídas y apaga todos los buzzers.
     */
    public function actionMarcarTodasLeidas()
    {
        $pendientes = AlertasHistorial::find()
            ->where(['leida_por_usuario' => 0])
            ->all();

        if (empty($pendientes)) {
            \Yii::$app->session->setFlash('info', 'No hay alertas pendientes.');
            return $this->redirect(['index']);
        }

        $dispositivosAfectados = [];

        foreach ($pendientes as $alerta) {
            $alerta->leida_por_usuario = 1;
            $alerta->save(false);

            if ($alerta->id_dispositivo) {
                $dispositivosAfectados[] = $alerta->id_dispositivo;
            }
        }

        // Apagar buzzer de cada dispositivo único afectado
        foreach (array_unique($dispositivosAfectados) as $idDisp) {
            \Yii::$app->db->createCommand('
                UPDATE estado_actuadores
                SET    buzzer_activo  = 0,
                       modo_operacion = :modo
                WHERE  id_dispositivo = :id
            ', [
                ':id'   => $idDisp,
                ':modo' => 'MANUAL',
            ])->execute();
        }

        $total = count($pendientes);
        \Yii::$app->session->setFlash('success', "{$total} alerta(s) marcadas como leídas y buzzers apagados.");

        return $this->redirect(['index']);
    }

    /**
     * Finds the AlertasHistorial model based on its primary key value.
     */
    protected function findModel($id_alerta)
    {
        if (($model = AlertasHistorial::findOne(['id_alerta' => $id_alerta])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}