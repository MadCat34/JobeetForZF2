<?php
namespace Front\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CategoryController extends AbstractActionController
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

    public function listAction()
    {
        $id_category = $this->params()->fromRoute('id', null);

        if (!is_null($id_category)) {
            $category = $this->categoryTable->getCategory($id_category);
            $jobs = $this->jobTable->fetchAllByIdCategory($id_category);
    
            return new ViewModel(
                array(
                    'category' => $category,
                    'jobs'     => $jobs
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