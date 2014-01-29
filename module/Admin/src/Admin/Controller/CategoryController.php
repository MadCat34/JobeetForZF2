<?php
namespace Admin\Controller;

use Jobeet\Controller\JobeetController;
use Jobeet\Form\CategoryForm;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

class CategoryController extends JobeetController
{

    public function indexAction()
    {
        $currentPage = $this->params()->fromRoute('page', null);
        $adapter = $this->categoryTable->getAdapter();
        $select = $this->categoryTable->getAll();
        
        $paginator = new Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $adapter));
        $paginator->setCurrentPageNumber($currentPage);
        $paginator->setDefaultItemCountPerPage($this->config['admin_element_pagination']);
        
        $categories = $paginator->getCurrentItems();
        
        return new ViewModel(array(
            'categories' => $categories,
            'paginator' => $paginator
        ));
    }

    public function addAction()
    {
        $formCategory = new CategoryForm();
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $category = $this->getServiceLocator()->get('Jobeet/Model/Category');
            
            $inputFilter = $category->getInputFilter();
            $formCategory->setInputFilter($inputFilter);
            $formCategory->setData($request->getPost());
            
            $formCategory->getInputFilter()
                ->get('name')
                ->getValidatorChain()
                ->attachByName('Db\NoRecordExists', array(
                'adapter' => $category->getDbAdapter(),
                'table' => 'category',
                'field' => 'name'
            ));
            
            $formCategory->getInputFilter()
                ->get('slug')
                ->getValidatorChain()
                ->attachByName('Db\NoRecordExists', array(
                'adapter' => $category->getDbAdapter(),
                'table' => 'category',
                'field' => 'slug'
            ));
            
            if ($formCategory->isValid()) {
                $category->exchangeArray($formCategory->getData());
                $this->categoryTable->saveCategory($category);
                
                $this->flashMessenger()->addMessage(array(
                    'success' => "Category '{$category->name}' was added successfully"
                ));
                return $this->redirect()->toRoute('zfcadmin/category');
            }
        }
        
        return new ViewModel(array(
            'form' => $formCategory
        ));
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $formCategory = new CategoryForm();
        $formCategory->get('submit')->setValue('Modifier');
        $idCategory = $this->params()->fromRoute('id', null);
        
        if ($request->isPost()) {
            $category = $this->getServiceLocator()->get('Jobeet/Model/Category');
            $formCategory->setData($request->getPost());
            $category->id_category = $idCategory;
            $formCategory->setInputFilter($category->getInputFilter());
            
            $formCategory->getInputFilter()
                ->get('name')
                ->getValidatorChain()
                ->attachByName('Db\NoRecordExists', array(
                'adapter' => $category->getDbAdapter(),
                'table' => 'category',
                'field' => 'name',
                'exclude' => array(
                    'field' => 'id_category',
                    'value' => $category->id_category
                )
            ));
            
            $formCategory->getInputFilter()
                ->get('slug')
                ->getValidatorChain()
                ->attachByName('Db\NoRecordExists', array(
                'adapter' => $category->getDbAdapter(),
                'table' => 'category',
                'field' => 'slug',
                'exclude' => array(
                    'field' => 'id_category',
                    'value' => $category->id_category
                )
            ));
            
            if ($formCategory->isValid()) {
                $category->exchangeArray($formCategory->getData());
                $this->categoryTable->saveCategory($category);
                $this->flashMessenger()->addMessage(array(
                    'success' => "Category '{$category->name}' was updated successfully"
                ));
                return $this->redirect()->toRoute('zfcadmin/category');
            }
        }
        
        $category = $this->categoryTable->getCategoryById($idCategory);
        $formCategory->setData($category->getArrayCopy());
        
        return new ViewModel(array(
            'form' => $formCategory
        ));
    }

    public function deleteAction()
    {
        $flashMessenger = $this->getServiceLocator()->get('jobeet_flashmessenger');
        $idCategory = $this->params()->fromRoute('id', null);
        $nbResult = $this->categoryTable->deleteCategory(array(
            'id_category = ?' => $idCategory
        ));
        
        if ($nbResult >= 1) {
            $this->flashMessenger()->addMessage(array(
                'success' => "Category {$idCategory} was deleted!"
            ));
        } else {
            $this->flashMessenger()->addMessage(array(
                'error' => "Category {$idCategory} can't be deleted!"
            ));
        }
        
        return $this->redirect()->toRoute('zfcadmin/category');
    }
}
