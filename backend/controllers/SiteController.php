<?php

namespace backend\controllers;

use common\models\LoginForm;
use common\models\Dispositivos;
use common\models\LecturasSensores;
use common\models\AlertasHistorial;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\PermisosHelpers;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow'   => true,
                    ],
                    [
                        'actions' => ['index'],
                        'allow'   => true,
                        'roles'   => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return PermisosHelpers::requerirMinimoRol('Admin')
                                && PermisosHelpers::requerirEstado('Activo');
                        }
                    ],
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
        ];
    }

    /**
     * Displays homepage con datos reales.
     */
    public function actionIndex()
    {
        // Filtro de período desde query param (?periodo=semana|global)
        $periodo = Yii::$app->request->get('periodo', 'hoy');

        // ── Dispositivos ──────────────────────────────────────────
        $totalDispositivos = Dispositivos::find()->count();

        // ── Lecturas según período ─────────────────────────────────
        $queryLecturas = LecturasSensores::find();
        switch ($periodo) {
            case 'semana':
                $desde = date('Y-m-d 00:00:00', strtotime('-6 days'));
                $queryLecturas->where(['>=', 'fecha_hora', $desde]);
                break;
            case 'global':
                // Sin filtro de fecha
                break;
            default: // hoy
                $queryLecturas->where(['>=', 'fecha_hora', date('Y-m-d 00:00:00')]);
                break;
        }
        $totalLecturas = $queryLecturas->count();

        // ── Alertas pendientes (sin leer) ─────────────────────────
        $alertasPendientes = AlertasHistorial::find()
            ->where(['leida_por_usuario' => 0])
            ->count();

        // ── Alertas según período ──────────────────────────────────
        $queryAlertas = AlertasHistorial::find();
        switch ($periodo) {
            case 'semana':
                $queryAlertas->where(['>=', 'fecha_hora', date('Y-m-d 00:00:00', strtotime('-6 days'))]);
                break;
            case 'global':
                break;
            default:
                $queryAlertas->where(['>=', 'fecha_hora', date('Y-m-d 00:00:00')]);
                break;
        }
        $totalAlertas = $queryAlertas->count();

        return $this->render('index', [
            'periodo'           => $periodo,
            'totalDispositivos' => $totalDispositivos,
            'totalLecturas'     => $totalLecturas,
            'alertasPendientes' => $alertasPendientes,
            'totalAlertas'      => $totalAlertas,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->loginAdmin()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}