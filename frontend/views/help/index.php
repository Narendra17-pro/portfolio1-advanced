
 <?php
/** @var yii\web\View $this */
use yii\helpers\Html;
 $this->title = 'HelpCenter';
 $this->params['breadcrumbs'][] = $this->title;
?>

<div class="help-index">
    <h1><?= Html::encode($this->title); ?></h1>
    t has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock,
    a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur,
    from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the
    undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The
    Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very p

<?= Html::a('Account Settings', ['help/account-settings']) ?>
<?= Html::a('Login And Security', ['help/login-and-seccurity ']) ?>

    <code><?= __FILE__ ?></code>
</div>

