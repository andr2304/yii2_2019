<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 09.04.2020
 * Time: 12:46
 */

namespace backend\controllers\shop;

use backend\forms\search\shop\CategorySearch;
use backend\forms\shop\CategoryForm;
use common\entities\shop\Category;
use common\useCases\manage\shop\CategoryService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class CategoryController extends Controller
{
    public $service;

    public function __construct(string $id, $module, CategoryService $categoryService, array $config = [])
    {
        $this->service = $categoryService;
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
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new CategoryForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()){
            try{
                $category = $this->service->create($form);
                Yii::$app->session->setFlash('success', 'Category has created');
                return $this->redirect(['view', 'id' => $category->id]);
            }catch (\DomainException $e) {
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
            'category' => $this->findModel($id),
        ]);
    }


    public function actionUpdate($id)
    {

        $category = $this->findModel($id);

        $form = new CategoryForm($category);

        if ($form->load(\Yii::$app->request->post()) && $form->validate()){
            try{
                $this->service->edit($id, $form);
                Yii::$app->session->setFlash('success', 'Category has updated');
                return $this->redirect(['view', 'id' => $category->id]);
            }catch (\DomainException $e) {
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
            $this->service->delete($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @return Category the loaded model
     * @throws \RuntimeException if the model cannot be found
     */
    protected function findModel($id): Category
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }
        throw new \RuntimeException('The requested page does not exist.');
    }

}