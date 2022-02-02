<?php

/* @var $this yii\web\View */
/* @var $discount shop\entities\Shop\Discount */
/* @var $model shop\forms\manage\Shop\DiscountForm */

$this->title = 'Update Discount: ' . $discount->name;
$this->params['breadcrumbs'][] = ['label' => 'Discounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $discount->name, 'url' => ['view', 'id' => $discount->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tag-update">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>