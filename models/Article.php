<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;
/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $date
 * @property string $image
 * @property int $viewed
 * @property int $user_id
 * @property int $status
 * @property int $category_id
 *
 * @property ArticleTag[] $articleTags
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
         return [
            [['title'], 'required'],
            [['title','description','content'], 'string'],
            [['date'], 'date', 'format'=>'php:Y-m-d'],
            [['date'], 'default', 'value' => date('Y-m-d')],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Статьи',
            'description' => 'Заголовок',
            'content' => 'Описание',
            'date' => 'Дата',
            'image' => 'Изображение',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTags()
    {
        return $this->hasMany(ArticleTag::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['article_id' => 'id']);
    }

    public function getAll($pageSize=3)
    {
        $query = Article::find();

        $count = $query->count();

        $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>$pageSize]);

        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $data['articles']=$articles;
        $data['pagination']=$pagination;

        return $data;
    }

    // Save Images
    public function saveImage($filename){
        $this->image=$filename;
        return $this->save(false);
    }

    // Get Images
    public function getImage()
    {
        if ($this->image) {
            return '/uploads/'.$this->image;
        }
        return '/noimage.png';
    }

    // Delete Images
    public function deleteImage()
    {
        $imageUploadModel = new ImageUplead();
        $imageUploadModel -> deleteCurrentImaage($this->image);
    }

    // Before Images
    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete();
    }

    // Get Category
    function getCategory()
    {
        return $this->hasOne(Category::className(), ['id'=>'category_id']);
    }

    // Save Article
    function saveCategory($caategory_id)
    {
        $category = Category::findOne($category_id);
        if ($category != null) {
            $this -> link('category', $category);
            return true;
        }
    }

    // Add Tags
        public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('article_tag', ['article_id' => 'id']);
    }

    public function getSelectedTags()
    {
        $selectedIds = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedIds, 'id');
    }

    // Save
    public function saveTags($tags)
    {
        if (is_array($tags)) {
            foreach ($tags as $tag_id) {
                $tag=Tag::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }

    public function clearCurrentTags()
    {
        ArticleTag::deleteAll(['article_id'=>$this->id]);
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->date);
    }

    //Side Bar

    public function getPopular()
    {
        return Article::find()->orderBy('viewed desc')->limit(3)->all();
    }

    public function getRecent()
    {
        return Article::find()->orderBy('date asc')->limit(2)->all();
    }
}
