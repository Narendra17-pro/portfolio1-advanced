<?php

namespace common\models;

use Yii;
use yii\imagine\Image;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $name
 * @property string $tech_stack
 * @property string $description
 * @property int $start_date
 * @property int $end_date
 *
 *  @property ProjectImage[] $images
 *  @property Testimonial[] $testimonials
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    /**
     * @var \GuzzleHttp\Psr7\UploadedFile
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public $imageFile;
    public $image_path;
    public function rules()
    {
        return [
            [['name', 'tech_stack', 'description', 'start_date', 'end_date'], 'required'],
            [['tech_stack', 'description'], 'string'],
            [['start_date', 'end_date'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['imageFile'],'file','skipOnEmpty'=>false,'extensions'=>'png,jpg,jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getImages()
    {
        return $this->hasMany(ProjectImage::class, ['project_id' => 'id']);
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'tech_stack' => Yii::t('app', 'Tech Stack'),
            'description' => Yii::t('app', 'Description'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'image_path'=>Yii::t('app', 'Image'),
            
        ];
    }

    /**
     * {@inheritdoc}
     * @return ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectQuery(get_called_class());
    }

    public function saveImage()
    {
        Yii::$app->db->transaction(function($db) {
            /**
             * @var $db yii\db\Connection
             */
           
            
            // Create a new File record for storing image metadata
            $file = new File();
            $file->name = uniqid(true) . '.' . $this->imageFile->extension;
            $file->base_url = Yii::$app->urlManager->createAbsoluteUrl('uploads/projects');
            $file->mime_type = mime_content_type($this->imageFile->tempName);
            Yii::info('Saving file: ' . $file->name, __METHOD__);

            // Save the file record to the File table
            if (!$file->save()) {
                $db->transaction->rollBack();
                return false; // Failed to save the file metadata
            }
    
            // Now save the file to disk (ensure the directory exists)
            if (!$this->imageFile->saveAs(Yii::$app->params['uploads']['projects'] . '/' . $file->name)) {
                $db->transaction->rollBack();
                return false; // Failed to save the file to disk
            }
    
            // If you want to store the image path directly in the Project table, update it here
            $this->image_path = $file->base_url . '/' . $file->name;
    
            // Save the project image association (if you're using a related table like ProjectImage)
            $projectImage = new ProjectImage();
            $projectImage->project_id = $this->id;
            $projectImage->file_id = $file->id;
            if (!$projectImage->save()) {
                $db->transaction->rollBack();
                return false; // Failed to save the image association
            }
            
            return true; // Image saved successfully
        });
    }
    

    public function hasImages(){
        return count($this->images) > 0;
    }
   

    
}
