<?php

namespace app\controllers;

use Yii;
use app\models\Parameters;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;


class ParametersController extends Controller
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
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Parameters::find(),
           
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**

     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException 
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Parameters();

        if ($this->request->isPost) {
            $model->icon = UploadedFile::getInstance($model, 'icon');
            $model->icon_gray = UploadedFile::getInstance($model, 'icon_gray');
            if ($model->load($this->request->post()) && $model->upload() && $model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $model->icon = UploadedFile::getInstance($model, 'icon');
            $model->icon_gray = UploadedFile::getInstance($model, 'icon_gray');
            if ($model->load($this->request->post()) && $model->upload() && $model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param int $id ID
     * @return Parameters 
     * @throws NotFoundHttpException 
     */
    protected function findModel($id)
    {
        if (($model = Parameters::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return \yii\web\Response
     */
    public function actionApiParameters()
    {
        $parameters = Parameters::find()->where(['type' => 2])->all();
        $result = [];
        foreach ($parameters as $parameter) {
            $result[] = [
                'id' => $parameter->id,
                'title' => $parameter->title,
                'icon' => [
                    'name' => basename($parameter->icon),
                    'url' => Yii::$app->request->hostInfo . '/' . $parameter->icon,
                ],
                'icon_gray' => [
                    'name' => basename($parameter->icon_gray),
                    'url' => Yii::$app->request->hostInfo . '/' . $parameter->icon_gray,
                ],
            ];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $result;
    }
}
