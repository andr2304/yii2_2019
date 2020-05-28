<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 21.04.2020
 * Time: 11:38
 */

namespace backend\controllers\shop;


use backend\forms\search\shop\product\ProductSearch;
use backend\forms\shop\Product\PhotosForm;
use backend\forms\shop\Product\ProductCreateForm;
use backend\forms\shop\Product\ProductEditForm;
use common\entities\shop\product\Product;
use common\useCases\manage\shop\ProductService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ProductController extends Controller
{
    public $service;

    public function __construct(string $id, $module, ProductService $service, array $config = [])
    {
        $this->service = $service;
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
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new ProductCreateForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()){
            try{
                $product = $this->service->create($form);
                Yii::$app->session->setFlash('success', 'Product has created');
                return $this->redirect(['view', 'id' => $product->id]);
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
        $product = $this->findModel($id);

        $photosForm = new PhotosForm();
        if ($photosForm->load(Yii::$app->request->post()) && $photosForm->validate()) {
            try {
                $this->service->addPhotos($product->id, $photosForm);
                return $this->redirect(['view', 'id' => $product->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('view', [
            'product' => $product,
            'photosForm' => $photosForm,
        ]);
    }

    public function actionUpdate($id)
    {

        $product = $this->findModel($id);

        $form = new ProductEditForm($product);

        if ($form->load(\Yii::$app->request->post()) && $form->validate()){
            try{
                $this->service->edit($id, $form);
                Yii::$app->session->setFlash('success', 'Product has updated');
                return $this->redirect(['view', 'id' => $product->id]);
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
     * @return Product the loaded model
     * @throws \RuntimeException if the model cannot be found
     */
    protected function findModel($id): Product
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }
        throw new \RuntimeException('The requested page does not exist.');
    }
}