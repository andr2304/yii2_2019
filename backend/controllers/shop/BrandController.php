<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 09.04.2020
 * Time: 12:46
 */

namespace backend\controllers\shop;

use backend\forms\search\shop\BrandSearch;
use backend\forms\shop\BrandForm;
use common\entities\shop\Brand;
use common\helpers\DebugHelper;
use common\useCases\manage\shop\BrandService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class BrandController extends Controller
{
    public $service;

    public function __construct(string $id, $module, BrandService $tagService, array $config = [])
    {
        $this->service = $tagService;
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new BrandSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new BrandForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()){
            try{
                $brand = $this->service->create($form);
                Yii::$app->session->setFlash('success', 'Brand has created');
                return $this->redirect(['view', 'id' => $brand->id]);
            }catch (\RuntimeException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'brand' => $this->findModel($id),
        ]);
    }


    public function actionUpdate($id)
    {

        $brand = $this->findModel($id);

        $form = new BrandForm($brand);

        if ($form->load(\Yii::$app->request->post()) && $form->validate()){
            try{
                $this->service->edit($id, $form);
                Yii::$app->session->setFlash('success', 'Brand has updated');
                return $this->redirect(['view', 'id' => $brand->id]);
            }catch (\RuntimeException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form
        ]);
    }


    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @return Brand the loaded model
     * @throws \RuntimeException if the model cannot be found
     */
    protected function findModel($id): Brand
    {
        if (($model = Brand::findOne($id)) !== null) {
            return $model;
        }
        throw new \RuntimeException('The requested page does not exist.');
    }

}