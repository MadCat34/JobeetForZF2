<?php
namespace Jobeet\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Exception\InvalidQueryException;

class CategoryTable
{
    /**
     * @var TableGateway
     */
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getAdapter()
    {
    	return $this->tableGateway->getAdapter();
    }
    
    public function getAll()
    {
        $select = new \Zend\Db\Sql\Select();
        $select->from($this->tableGateway->getTable());
        return $select;
    }
    
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getCategoryBySlug($slug)
    {
        $rowset = $this->tableGateway->select(array('slug' => $slug));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $slug");
        }

        return $row;
    }
    
    public function getCategoryById($id)
    {
        $rowset = $this->tableGateway->select(array('id_category' => $id));
        $row = $rowset->current();
        
        if (!$row) {
            throw new \Exception("Could not find row with id $id");
        }
        
        return $row;
    }

    public function saveCategory(Category $category)
    {
        $data = array(
            'id_category' => $category->id_category,
            'name'  => $category->name,
            'slug'  => $category->slug
        );

        $id = (int)$category->id_category;

        if ($id == 0) {
            $this->tableGateway->insert($data);
        } elseif ($this->getCategoryById($id)) {
            $this->tableGateway->update($data, array('id_category = ?' => $id));
        } else {
            throw new \Exception('Form id does not exist');
        }
    }

    public function deleteCategory($id)
    {
        try {
            return $this->tableGateway->delete(array('id_category' => $id));
        } catch (InvalidQueryException $e) {
            return 0;
        }
    }
}
