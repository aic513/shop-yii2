<?php

use kartik\widgets\DatePicker;
use shop\entities\Shop\Discount;
use shop\helpers\DiscountHelper;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Shop\DiscountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Discounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Create Discount', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'name',
                        'value' => function (Discount $model) {
                            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    'percent',
                    [
                        'attribute' => 'from_date',
                        'value' => 'from_date',
                        'format' => 'raw',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'name' => 'DiscountSearch[from_date]',
                            'value' => ArrayHelper::getValue(Yii::$app->request->get(), "DiscountSearch.from_date"),
                            'pluginOptions' => [
                                'format' => 'yyyy-mm-dd',
                                'autoclose' => true,
                            ]
                        ])
                    ],
                    [
                        'attribute' => 'to_date',
                        'value' => 'to_date',
                        'format' => 'raw',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'name' => 'DiscountSearch[to_date]',
                            'value' => ArrayHelper::getValue(Yii::$app->request->get(), "DiscountSearch.to_date"),
                            'convertFormat' => true,
                            'pluginOptions' => [
                                'format' => 'yyyy-M-dd',
                                'autoclose' => true,
                            ]
                        ])
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => $searchModel->statusList(),
                        'value' => function (Discount $model) {
                            return DiscountHelper::statusLabel($model->status);
                        },
                        'format' => 'raw',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
