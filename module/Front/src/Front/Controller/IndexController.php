<?php
namespace Front\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Front\Model\JobTable;
use Front\Model\CategoryTable;

class IndexController extends JobeetController
{
    public function indexAction()
    {
        $categories = $this->categoryTable->fetchAll();
        $results = array();

        foreach ($categories as $category) {
            $jobs = $this->jobTable->fetchByIdCategoryWithLimit(
                $category->idCategory,
                $this->config['nb_job_by_category'],
                $this->config['job_nb_valid_days']
            );
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
