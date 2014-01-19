<?php
namespace Front\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class JobController extends AbstractActionController
{
    protected $jobTable;
    protected $categoryTable;
    
    public function __construct($category, $job)
    {
        $this->categoryTable = $category;
        $this->jobTable = $job;
    }
    
    public function setCategoryTable($category)
    {
    	$this->categoryTable = $category;
    }
    
    public function setJobTable($job)
    {
    	$this->jobTable = $job;
    }
    
    public function indexAction()
    {
        return new ViewModel();
    }

    public function getAction()
    {
        $id_job = $this->params()->fromRoute('id', null);
        
        if (!is_null($id_job)) {
            $job = $this->jobTable->getJob($id_job);
            $category = $this->categoryTable->getCategory($job->idCategory);
        
            return new ViewModel(
                array(
                    'job'     => $job,
                    'category' => $category
                )
            );
        } else {
            $this->getResponse()->setStatusCode(404);
            return;
        }
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