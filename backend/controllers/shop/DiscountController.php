<?php

namespace backend\controllers\shop;

use backend\forms\Shop\DiscountSearch;
use DomainException;
use shop\entities\Shop\Discount;
use shop\forms\manage\Shop\DiscountForm;
use shop\useCases\manage\Shop\DiscountManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DiscountController extends Controller
{
    private $service;
    
    public function __construct($id, $module, DiscountManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }
    
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DiscountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new DiscountForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $discount = $this->service->create($form);
                
                return $this->redirect(['view', 'id' => $discount->id]);
            } catch (DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        
        return $this->render('create', [
            'model' => $form,
        ]);
    }
    
    /**
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $discount = $this->findModel($id);
        
        $form = new DiscountForm($discount);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($discount->id, $form);
                
                return $this->redirect(['view', 'id' => $discount->id]);
            } catch (DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        
        return $this->render('update', [
            'model' => $form,
            'discount' => $discount,
        ]);
    }
    
    /**
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        
        return $this->redirect(['index']);
    }
    
    /**
     * @param integer $id
     *
     * @return mixed
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'discount' => $this->findModel($id),
        ]);
    }
    
    /**
     * @param integer $id
     *
     * @return mixed
     */
    public function actionActivate($id)
    {
        try {
            $this->service->activate($id);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        
        return $this->redirect(['view', 'id' => $id]);
    }
    
    /**
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDraft($id)
    {
        try {
            $this->service->draft($id);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        
        return $this->redirect(['view', 'id' => $id]);
    }
    
    /**
     * @param integer $id
     *
     * @return Discount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Discount
    {
        if (($model = Discount::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}