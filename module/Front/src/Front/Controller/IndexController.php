<?php
namespace Front\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Front\Model\JobTable;

class IndexController extends AbstractActionController
{
    protected $jobTable;
    protected $categoryTable;
    
    public function getJobTable()
    {
        if (!$this->jobTable) {
            $sm = $this->getServiceLocator();
            $this->jobTable = $sm->get('Front\Model\JobTable');
        }
        return $this->jobTable;
    }
    
    public function getCategoryTable()
    {
    	if (!$this->categoryTable) {
    		$sm = $this->getServiceLocator();
    		$this->categoryTable = $sm->get('Front\Model\CategoryTable');
    	}
    	return $this->categoryTable;
    }
    
    public function indexAction()
    {
        $categories = $this->getCategoryTable()->fetchAll();
        $results = array();
        
        foreach ($categories as $category) {
            $jobs = $this->getJobTable()->fetchAllByIdCategory($category->idCategory);
            $results[$category->name] = $jobs;
        }
        
        return new ViewModel(
            array(
                'categories' => $results,
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