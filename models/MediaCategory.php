<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "media_category".
 *
 * @property integer $id
 * @property integer $parent_id
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
	    $roots = array();
	    $items = self::items();
	    foreach($items as $index => $item)
	    {
		    if($item['parent_id'] === null){
			    $roots[$item['id']] = $item['title'];
			    unset($items[$index]);
		    }
	    }
	    foreach($roots as $id => $title)
	    {
		    $tree[$id] = $title;
		    $tree += self::getChildren($items, $id);
		    
	    }

	    return $tree;
    }
    
    private static function getChildren($items, $node_id)
    {
	    $result = array();
	    static $depth;
	    $depth++;
	    foreach($items as $index => $item)
	    {
			if($node_id == $item['parent_id']){
				$result[$item['id']] = str_repeat('–', $depth) . $item['title'];
				unset($items[$index]);
				$result += self::getChildren($items, $item['id']);
			}
	    }
	    $depth--;
	    
	    return $result;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::className(), ['category_id' => 'id']);
    }
}
