<?php
class News_Entity extends EMongoEmbeddedDocument
{

    public $id;
    public $entity_id;
    public $name;
    public $title;
    public $link;
    public $text;
    public $image;
    public $imageName;
    public $created_at;
    public $template;
    public $cost;
    public $filter;
	public $deleted = 0;


    public $params;

    public function embeddedDocuments() {  // встроенные, суб массивы!
        return array(
            // property name => embedded document class name
            'comment' => 'News_Entity_Comment',
            'likes' => 'News_Entity_Likes',
            'dislikes' => 'News_Entity_Likes',
        );
    }

    // We can define rules for fields, just like in normal CModel/CActiveRecord classes
    public function rules()
    {
        return array(
            array('id, name, template, title, text, filter, link', 'required'),
        );
    }

}