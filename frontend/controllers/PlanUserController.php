<?php

namespace app\controllers;

use Yii;
use app\models\extend\PlanUser;
use app\models\search\PlanUserSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class PlanUserController extends \app\components\ext\BaseController {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex($plan_id) {
        $searchModel = new PlanUserSearch();
        $searchModel->status = 0;
        $searchModel->plan_id = $plan_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate() {
        $model = new PlanUser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'plan_id' => $model->plan_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDelete($id) {
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->updateAttributes(['status' => -1]);

        return $this->redirect(['index', 'plan_id' => $model->plan_id]);
    }

    protected function findModel($id) {
        if (($model = PlanUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionRemove() {
        $plan_id = Yii::$app->request->get('plan_id');
        $uid = Yii::$app->request->get('uid');

        $model = PlanUser::findOne(['plan_id' => $plan_id, 'uid' => $uid, 'status' => 0]);
        $model->updateAttributes(['status' => -1]);

        return $this->redirect(['plan/my', 'plan_id' => $model->plan_id]);
    }
    
    public function actionBatchUpdate() {
        $planUsers = $_POST['planUser'];
        $planId = $_POST['plan_id'];
        if (!is_array($planUsers)) {
            throw new NotFoundHttpException('请求错误!');
        }
        foreach ($planUsers as $key => $role) {
            $model = PlanUser::findOne($key);
            $model->role_name = $role['role_name'];
            $model->instruction = $role['instruction'];
            $model->save();
        }

        return $this->redirect(['plan/view', 'id' => $planId]);
    }

}
