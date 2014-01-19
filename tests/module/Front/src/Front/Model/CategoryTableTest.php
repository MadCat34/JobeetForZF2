<?php
use Front\Model\Category;
use Zend\Db\ResultSet\ResultSet;
use Front\Model\CategoryTable;

class CategoryTableTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
    }

    public function testFetchAllReturnsAllCategories()
    {
        $resultSet        = new ResultSet();
        $mockTableGateway = $this->getMock(
                              'Zend\Db\TableGateway\TableGateway',
                              array('select'), array(), '', false
                            );
        
        $mockTableGateway->expects($this->once())
                         ->method('select')
                         ->with()
                         ->will($this->returnValue($resultSet));
    
        $categoryTable = new CategoryTable($mockTableGateway);
        $this->assertSame($resultSet, $categoryTable->fetchAll());
    }

    public function testCanRetrieveACategoryByItsId()
    {
        $category = new Category();
        $category->exchangeArray(
            array(
                'id_category' => 125,
                'title'  => 'WEB DESIGNER'
            )
        );
    
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Category());
        $resultSet->initialize(array($category));
    
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('select')
                         ->with(array('id_category' => 125))
                         ->will($this->returnValue($resultSet));
    
        $categoryTable = new CategoryTable($mockTableGateway);
        $this->assertSame($category, $categoryTable->getCategory(125));
    }
    
    public function testCanDeleteACategoryByItsId()
    {
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('delete'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('delete')
                         ->with(array('id' => 125));
    
        $categoryTable = new CategoryTable($mockTableGateway);
        $categoryTable->deleteCategory(125);
    }
    
    public function testSaveCategoryWillInsertNewCategoryIfTheyDontAlreadyHaveAnId()
    {
        $categoryData = array('id_category' => null, 'name' => 'GRAPHISTE');
        $category     = new Category();
        $category->exchangeArray($categoryData);
    
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('insert')
                         ->with($categoryData);
    
        $categoryTable = new CategoryTable($mockTableGateway);
        $categoryTable->saveCategory($category);
    }
    
    public function testSaveCategoryWillUpdateExistingCategoryIfTheyAlreadyHaveAnId()
    {
        $categoryData = array('id_category' => 123, 'name' => 'Project Manager');
        
        $category     = new Category();
        $category->exchangeArray($categoryData);
    
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Category());
        $resultSet->initialize(array($category));
    
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select', 'update'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('select')
                         ->with(array('id_category' => 123))
                         ->will($this->returnValue($resultSet));
        
        $mockTableGateway->expects($this->once())
                         ->method('update')
                         ->with(array('id_category'=>123, 'name' => 'Project Manager'), array('id_category' => 123));
    
        $categoryTable = new CategoryTable($mockTableGateway);
        $categoryTable->saveCategory($category);
    }
    
    public function testExceptionIsThrownWhenGettingNonexistentCategory()
    {
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Category());
        $resultSet->initialize(array());
    
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('select')
                         ->with(array('id_category' => 123))
                         ->will($this->returnValue($resultSet));
    
        $categoryTable = new CategoryTable($mockTableGateway);
    
        try
        {
            $categoryTable->getCategory(123);
        }
        catch (\Exception $e)
        {
            $this->assertSame('Could not find row 123', $e->getMessage());
            return;
        }
    
        $this->fail('Expected exception was not thrown');
    }
}