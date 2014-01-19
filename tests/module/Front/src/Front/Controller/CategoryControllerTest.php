<?php
namespace Front\Controller;

use Front\Model\Job;
use Front\Model\Category;
use Front\Model\CategoryTable;
use Front\Model\JobTable;
use Zend\Db\ResultSet\ResultSet;
use Front\Controller\CategoryController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PHPUnit_Framework_TestCase;

class CategoryControllerTest extends PHPUnit_Framework_TestCase
{
    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;
    
    protected function setUp()
    {
        $bootstrap        = \Zend\Mvc\Application::init(include 'config/application.config.php');
        
        // La partie intéressante: nous "créons" un modèle Category
        $categoryData = array('id_category' => 1, 'name' => 'Project Manager');
        $category     = new Category();
        $category->exchangeArray($categoryData);
        $resultSetCategory = new ResultSet();
        $resultSetCategory->setArrayObjectPrototype(new Category());
        $resultSetCategory->initialize(array($category));
        $mockCategoryTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
        $mockCategoryTableGateway->expects($this->any())
                         ->method('select')
                         ->with()
                         ->will($this->returnValue($resultSetCategory));
        $categoryTable = new CategoryTable($mockCategoryTableGateway);
        
        $jobData = array(
            'id_job' => 1,
            'id_category' => 1,
            'type' => 'typeTest',
            'company' => 'companyTest',
            'logo' => 'logoTest',
            'url' => 'urlTest',
            'position' => 'positionTest',
            'location' => 'locaitonTest',
            'description' => 'descriptionTest',
            'how_to_play' => 'hotToPlayTest',
            'is_public' => 1,
            'is_activated' => 1,
            'email' => 'emailTest',
            'created_at' => '2012-01-01 00:00:00',
            'updated_at' => '2012-01-01 00:00:00'
        );
        $job = new Job();
        $job->exchangeArray($jobData);
        $resultSetJob = new ResultSet();
        $resultSetJob->setArrayObjectPrototype(new Category());
        $resultSetJob->initialize(array($job));
        $mockJobTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
        $mockJobTableGateway->expects($this->any())
                            ->method('select')
                            ->with(array('id_category' => 1))
                            ->will($this->returnValue($resultSetJob));
        $jobTable = new JobTable($mockJobTableGateway);
        
        $this->controller = new CategoryController($categoryTable, $jobTable);
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'category'));
        $this->event      = $bootstrap->getMvcEvent();
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setEventManager($bootstrap->getEventManager());
        $this->controller->setServiceLocator($bootstrap->getServiceManager());
    }
    
    public function testListActionCanBeAccessed()
    {
        $this->routeMatch->setParam('action', 'list');
        $this->routeMatch->setParam('id', '1');
        
        $category = new Category();
        $category->exchangeArray(
            array(
                'id_category' => 1,
                'title'  => 'WEB DESIGNER'
            )
        );
        
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Category());
        $resultSet->initialize(array($category));
        
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
        $mockTableGateway->expects($this->any())
                         ->method('select')
                         ->with(array('id_category' => 1))
                         ->will($this->returnValue($resultSet));
        $categoryTable = new CategoryTable($mockTableGateway);
        $this->controller->setCategoryTable($categoryTable);
        
        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }
    
    public function testListActionCantBeAccessedIfCategoryIdIsMissing()
    {
        $this->routeMatch->setParam('action', 'list');
        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
    }
    
    public function test404WhenActionDoesNotExist()
    {
        $this->routeMatch->setParam('action', 'autre-action');
        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
    }
}
