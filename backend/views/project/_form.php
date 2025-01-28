<?php

use yii\helpers\Html;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\project $model */
/** @var yii\widgets\ActiveForm $form */
$this->registerJsFile('@web/js/projectForm.js',['depends'=>[\yii\web\JqueryAsset::class]]);

?>

<div class="project-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tech_stack')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'start_date')->widget(\yii\jui\DatePicker::classname(), [
    'language' => 'en',
     'dateFormat' => 'yyyy-MM-dd',
     'options'=> ['readOnly' => true],
]) ?>
<?= $form->field($model, 'end_date')->widget(\yii\jui\DatePicker::classname(), [
    'language' => 'en',
     'dateFormat' => 'yyyy-MM-dd',
     'options'=> ['readOnly' => true],
]) ?>


    <?php foreach ($model->images as $image): ?>
        <div id="project-form__image-container-<?= $image->id?>"> 
    <?= Html::img(Yii::$app->urlManager->createAbsoluteUrl('uploads/projects/' . $image->file->name), [
        'alt' => 'Demonstration of the user interface',
        'height' => 200,
        'class' => 'img-thumbnail',
    ]) ?>
<?= Html::button(Yii::t('app','Delete'),['class'=>'btn btn-danger btn-delete-project',
'data-project-image-id'=>$image->id])?>

<div id="project-form__image-error-message-<?= $image->id?>" class="text-danger"></div>
</div>
<?php endforeach; ?>
  
        <?= $form->field($model,'image_path')->fileInput() ?>

   



    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
