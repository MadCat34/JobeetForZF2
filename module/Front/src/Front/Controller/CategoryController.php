<?php
namespace Front\Controller;

use Zend\Paginator\Paginator;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CategoryController extends JobeetController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function listAction()
    {
        $id_category = $this->params()->fromRoute('id', null);
        $currentPage = $this->params()->fromRoute('page', null);

        $adapter = $this->jobTable->getAdapter();
        //$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        
        $select = $this->jobTable->getActiveJobsForPagination($id_category, $this->config['job_nb_valid_days']);
        $paginator = new Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $adapter));
        $paginator->setCurrentPageNumber($currentPage);
        $paginator->setDefaultItemCountPerPage($this->config['nb_job_pagination']);

        if (!is_null($id_category)) {
            $category = $this->categoryTable->getCategory($id_category);
            $jobs = $paginator->getCurrentItems();

            return new ViewModel(
                array(
                    'category' => $category,
                    'jobs'     => $jobs,
                    'paginator' => $paginator,
                    'id' => $id_category,
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
