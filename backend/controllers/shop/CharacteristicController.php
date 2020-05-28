<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 09.04.2020
 * Time: 12:46
 */

namespace backend\controllers\shop;



use backend\forms\search\shop\CharacteristicSearch;
use backend\forms\shop\CharacteristicForm;
use backend\forms\users\CreateUserForm;
use common\entities\shop\Characteristic;
use common\useCases\manage\shop\CharacteristicService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class CharacteristicController extends Controller
{
    public $service;

    public function __construct(string $id, $module, CharacteristicService $charService, array $config = [])
    {
        $this->service = $charService;
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
        $searchModel = new CharacteristicSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new CharacteristicForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()){
            try{
                $characteristic = $this->service->create($form);
                Yii::$app->session->setFlash('success', 'characteristic has created');
                return $this->redirect(['view', 'id' => $characteristic->id]);
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
            'characteristic' => $this->findModel($id),
        ]);
    }


    public function actionUpdate($id)
    {

        $characteristic = $this->findModel($id);

        $form = new CharacteristicForm($characteristic);

        if ($form->load(\Yii::$app->request->post()) && $form->validate()){
            try{
                $this->service->edit($id, $form);
                Yii::$app->session->setFlash('success', 'Characteristic has updated');
                return $this->redirect(['view', 'id' => $characteristic->id]);
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
     * @return Characteristic the loaded model
     * @throws \RuntimeException if the model cannot be found
     */
    protected function findModel($id): Characteristic
    {
        if (($model = Characteristic::findOne($id)) !== null) {
            return $model;
        }
        throw new \RuntimeException('The requested page does not exist.');
    }

}