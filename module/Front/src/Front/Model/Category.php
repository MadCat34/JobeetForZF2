<?php
namespace Front\Model;

class Category
{
    public $idCategory;
    public $name;
    
    public function exchangeArray($data)
    {
        $this->idCategory = (isset($data['id_category'])) ? $data['id_category'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
    }
}
