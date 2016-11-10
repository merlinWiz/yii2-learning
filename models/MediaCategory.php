<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use paulzi\adjacencyList\AdjacencyListBehavior;
use paulzi\adjacencyList\AdjacencyListQueryTrait;
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
			    'class' => AdjacencyListBehavior::className(),			    
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
            ['id', 'safe'],
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

	public static function find()
	{
		return new SampleQuery(get_called_class());
	}
	
	public function roots()
	{
		return self::find()->roots()->all();
	}
	
	public function tree()
	{
		$tree = [];
		foreach($this->roots() as $root)
		{
			$root->populateTree();
			$id = $root->id;
			$tree[$id] = $root->title;
			
			$tree += self::_getChildren($root);
			
		}
		
		return $tree;
	}
	
	public static function _getChildren($node)
	{
		static $depth = '-';
		
		
		$result = [];
		foreach($node->children as $child)
		{
			$id = $child->id;
			$result[$id] = $depth . $child->title;
			$depth .= '-';
			$result += self::_getChildren($child);
			$depth = substr($depth, 0, -1);
		}
		return $result;
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

class SampleQuery extends \yii\db\ActiveQuery
{
    use AdjacencyListQueryTrait;
}
