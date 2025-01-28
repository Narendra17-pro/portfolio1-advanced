<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap5\Modal;
use yii\grid\ActionColumn;
use common\models\project;

/** @var yii\web\View $this */
/** @var backend\models\ProjectSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->registerJsFile('@web/js/modal.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$this->title = Yii::t('app', 'Projects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button(Yii::t('app', 'Create Project'), [
            'class' => 'btn btn-success',
            'id' => 'create-project-button',
            'value' => Url::to(['project/create']), // URL to the create action
        ]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'tech_stack:ntext',
            'description:ntext',
            'start_date',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, project $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>
</div>

<?php
// Add the modal widget
Modal::begin([
    'id' => 'create-project-modal',
    'title' => '<h4>Create Project</h4>',
    'size' => Modal::SIZE_LARGE, // Optional: Change modal size if needed
]);

echo '<div id="create-project-content"></div>'; // Placeholder for content loaded via AJAX

Modal::end();
?>
