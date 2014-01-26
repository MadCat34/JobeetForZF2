<?php
namespace Front\Model;

class Category
{
    public $idCategory;
    public $name;
    public $slug;

    public function exchangeArray($data)
    {
        $this->idCategory = (isset($data['id_category'])) ? $data['id_category'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->slug = (isset($data['slug'])) ? $data['slug'] : Jobeet::slugify($this->name);
    }
    
    public function getArrayCopy()
    {
    	return get_object_vars($this);
    }
}
