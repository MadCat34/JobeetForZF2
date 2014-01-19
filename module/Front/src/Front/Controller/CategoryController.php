<?php
namespace Front\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CategoryController extends AbstractActionController
{
	protected $categoryTable;
	
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
		return new ViewModel(array(
			'category' => $this->getCategoryTable()->fetchAll(),
		));
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