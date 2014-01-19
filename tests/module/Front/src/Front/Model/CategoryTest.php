<?php
use Front\Model\Category;

class CategoryTest extends \PHPUnit_Framework_TestCase
{
    protected $category;
    
    protected function setUp()
    {
        $this->category = new Category();
    }
    
    protected function tearDown()
    {
    }
    public function testCategoryInitialState()
    {
        $this->assertNull($this->category->idCategory, '"idCategory" should initially be null');
        $this->assertNull($this->category->name, '"name" should initially be null');
    }
    
    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $data  = array(
            'id_category'     => 123,
            'name'  => 'some title'
        );
    
        $this->category->exchangeArray($data);
        $this->assertSame($data['id_category'], $this->category->idCategory, '"idCategory" was not set correctly');
        $this->assertSame($data['name'], $this->category->name, '"name" was not set correctly');
    }
    
    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $this->category->exchangeArray(
            array(
                'id_category'     => 1,
                'name'  => 'My Name'
            )
        );
        $this->category->exchangeArray(array());
        $this->assertNull($this->category->idCategory, '"idCategory" should have defaulted to null');
        $this->assertNull($this->category->name, '"name" should have defaulted to null');
    }
}