<?php
namespace Front\Controller;

use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use Front\Form\CategoryForm;
use Front\Model\Category;

class CategoryController extends JobeetController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function listAction()
    {
        // Get params from matched route
        $slug = $this->params()->fromRoute('slug', null);
        $currentPage = $this->params()->fromRoute('page', null);
        
        $adapter = $this->jobTable->getAdapter();
        
        if (!is_null($slug)) {
            $category = $this->categoryTable->getCategoryBySlug($slug);
            
            $select = $this->jobTable->getActiveJobsForPagination($category->idCategory, $this->config['job_nb_valid_days']);
            $paginator = new Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $adapter));
            $paginator->setCurrentPageNumber($currentPage);
            $paginator->setDefaultItemCountPerPage($this->config['nb_job_pagination']);
            
            $jobs = $paginator->getCurrentItems();

            return new ViewModel(
                array(
                    'category' => $category,
                    'jobs'     => $jobs,
                    'paginator' => $paginator,
                    'id' => $category->idCategory,
                    'slug' => $slug
                )
            );
        } else {
            $this->getResponse()->setStatusCode(404);
            return;
        }
    }

    public function addAction()
    {
        $formCategory = new CategoryForm();
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $category= new Category();
            $formCategory->setInputFilter($category->getInputFilter());
            $formCategory->setData($request->getPost());
        
            if ($formCategory->isValid()) {
                $category->exchangeArray($formCategory ->getData());
                $this->categoryTable->saveCategory($category);

                return $this->redirect()->toRoute('home');
            }
        }
        
        return new ViewModel(
            array(
                'form' => $formCategory
            )
        );
    }

    public function editAction()
    {
        
    }

    public function deleteAction()
    {
    }
}
