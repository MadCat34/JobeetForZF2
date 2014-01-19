<?php
namespace Front\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class CategoryTable extends AbstractTableGateway
{
    protected $table ='category';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Category());
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getCategory($id)
    {
        $id  = (int)$id;
        $rowset = $this->select(array('id_category' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }

        return $row;
    }

    public function saveCategory(Category $category)
    {
        $data = array(
            'id_category' => $category->idCategory,
            'name'  => $category->name
        );

        $id = (int)$category->idCategory;

        if ($id == 0) {
            $this->insert($data);
        } elseif ($this->getCategory($id)) {
            $this->update(
                $data,
                array(
                    'id_category' => $id,
                )
            );
        } else {
            throw new \Exception('Form id does not exist');
        }
    }

    public function deleteCategory($id)
    {
        $this->delete(array('id' => $id));
    }
}