<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use common\models\project;
use yii\filters\VerbFilter;
use common\models\ProjectImage;
use backend\models\ProjectSearch;
use yii\web\NotFoundHttpException;

/**
 * ProjectController implements the CRUD actions for project model.
 */
class ProjectController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'delete-projecct-image'=>['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all project models.
     *
     * @return string
     */
   public function actionIndex()
{
    $searchModel = new ProjectSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);

    // Create a new instance of the Project model for the modal form
    $model = new Project();

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'model' => $model, // Pass the model to the view
    ]);
}

    /**
     * Displays a single project model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Project();
    
        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'image_path');
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->save()) {
                    if ($model->imageFile) {
                        $model->saveImage();
                    }
                    Yii::$app->session->setFlash('success', 'Successfully saved');
                    return $this->redirect(['index']);
                }
            } else {
                Yii::$app->session->setFlash('error', 'Validation failed');
            }
        }
    
        // Check for AJAX request to render only the form
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    



    /**
     * Updates an existing project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
    
        if ($this->request->isPost && $model->load($this->request->post())) {
            // Get the uploaded file instance
            $model->imageFile = UploadedFile::getInstance($model, 'image_path');
    
            // Save the model first
            if ($model->save()) {
                // Only save a new image if one is uploaded
                if ($model->imageFile) {
                    $model->saveImage();
                }
    
                Yii::$app->session->setFlash('success', 'Successfully updated');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
    
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    

    /**
     * Deletes an existing project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteProjectImage()
    {
        
        $image = ProjectImage::findOne($this->request->post('id'));
    
        if (!$image) {
            throw new NotFoundHttpException('The requested image does not exist.');
        }
    
        $transaction = Yii::$app->db->beginTransaction();
    
        try {
            
            $file = $image->file;
            if ($file) {
                $path = Yii::$app->params['uploads']['projects'] . '/' . $file->name;
                if (file_exists($path)) {
                    unlink($path);
                }
                $file->delete(); 
            }
    
            $image->delete();
    
            $transaction->commit();
    
            return $this->asJson([
                'success' => true,
                'message' => 'Image deleted successfully',
            ]);
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->asJson([
                'success' => false,
                'message' => 'Failed to delete image: ' . $e->getMessage(),
            ]);
        }
    }
    



    /**
     * Finds the project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = project::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
