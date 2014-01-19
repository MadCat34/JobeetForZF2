<?php
namespace Front\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Front\Model\JobTable;
use Front\Model\CategoryTable;

class IndexController extends AbstractActionController
{
    protected $jobTable;
    protected $categoryTable;

    public function __construct($category, $job)
    {
    	$this->categoryTable = $category;
    	$this->jobTable = $job;
    }
    
    /*
    public function setCategoryTable(CategoryTable $categoryTable)
    {
    	$this->categoryTable = $categoryTable;
    }
    
    public function setJobTable(JobTable $jobTable)
    {
    	$this->jobTable = $jobTable;
    }
    */
    
    public function indexAction()
    {
        $categories = $this->categoryTable->fetchAll();
        $results = array();
        
        foreach ($categories as $category) {
            $jobs = $this->jobTable->fetchAllByIdCategory($category->idCategory);
            $results[] = array( 'category' => $category, 'job' => $jobs);
        }
        
        return new ViewModel(
            array(
                'results' => $results,
            )
        );
    }

    public function addAction()
    {
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
}