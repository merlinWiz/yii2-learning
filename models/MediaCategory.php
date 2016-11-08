<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "media_category".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $slug
 * @property string $title
 *
 * @property Media[] $media
 */
class MediaCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'media_category';
    }

    public function behaviors()
    {
	    return [
		    [
			    'class' => SluggableBehavior::className(),
			    'attribute' => 'title',
			    'slugAttribute' => 'slug',
			    'ensureUnique' => true,
		    ]
	    ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'exist', 'targetAttribute' => 'id'],
            [['title'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_id' => 'Родительская категория',
            'title' => 'Название',
        ];
    }
    
	private static $_items;
    
    public static function items()
    {
	    if(!isset(self::$_items)) self::loadItems();
	    return self::$_items;
    }
        
    private static function loadItems()
    {
	    self::$_items = self::find()->asArray()->all();
    }
    
    public static function itemsTree()
    {
	    $tree = array();
	    $items = self::items();
	    foreach($items as $item)
	    {
		    $depth = self::getDepth($item['id'], ArrayHelper::map($items, 'id', 'parent_id'));
		    $tree[$item['id']] = $depth . $item['title'];
	    }
	    return $tree;
    }
    
    private static function getDepth($id, $items)
    {
	    $parent = $items[$id];
		if(isset($parent)) return '–' . self::getDepth($parent, $items);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::className(), ['category_id' => 'id']);
    }
}
