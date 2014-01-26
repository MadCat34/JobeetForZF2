<?php
namespace Front\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class CategoryTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getCategory($id)
    {
        $id  = (int)$id;
        $rowset = $this->tableGateway->select(array('id_category' => $id));
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
            $this->tableGateway->insert($data);
        } elseif ($this->getCategory($id)) {
            $this->tableGateway->update($data, array('id_category' => $id));
        } else {
            throw new \Exception('Form id does not exist');
        }
    }

    public function deleteCategory($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}
