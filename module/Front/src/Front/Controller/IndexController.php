<?php
namespace Front\Controller;

use Jobeet\Controller\JobeetController;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

class IndexController extends JobeetController
{
    public function indexAction()
    {
        $categories = $this->categoryTable->fetchAll();
        $results = array();
        $adapter = $this->jobTable->getAdapter();

        foreach ($categories as $category) {
            $select = $this->jobTable->getActiveJobsForPagination($category->id_category, $this->config['job_nb_valid_days']);
            $paginator = new Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $adapter));
            $paginator->setCurrentPageNumber(0);
            $paginator->setDefaultItemCountPerPage($this->config['nb_job_by_category']);
            $jobs = $paginator->getCurrentItems();
            $activeJobs = $paginator->getTotalItemCount();
            
            $results[] = array(
                'category' => $category,
                'job' => $jobs,
                'activeJobs' => $activeJobs
            );
        }

        $nbJobByCategory = $this->config['nb_job_by_category'];
        return new ViewModel(
            array(
                'results' => $results,
                'nbJobByCategory'=> $nbJobByCategory,
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
