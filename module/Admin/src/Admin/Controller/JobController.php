<?php
namespace Admin\Controller;

use Jobeet\Controller\JobeetController;
use Jobeet\Form\JobForm;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use Zend\Debug\Debug;

class JobController extends JobeetController
{

    public function indexAction()
    {
        $currentPage = $this->params()->fromRoute('page', null);
        $adapter = $this->jobTable->getAdapter();
        $select = $this->jobTable->getAll();
        
        $paginator = new Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $adapter));
        $paginator->setCurrentPageNumber($currentPage);
        $paginator->setDefaultItemCountPerPage($this->config['admin_element_pagination']);
        
        $jobs = $paginator->getCurrentItems();
        
        return new ViewModel(array(
            'jobs' => $jobs,
            'paginator' => $paginator
        ));
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $formJob = new JobForm($this->categoryTable);
        $formJob->get('submit')->setValue('Modifier');
        $idJob = $this->params()->fromRoute('id', null);
        
        if ($request->isPost()) {
            $job = $this->getServiceLocator()->get('Jobeet/Model/Job');
            $formJob->setData($request->getPost());
            $job->id_job = $idJob;
            $formJob->setInputFilter($job->getInputFilter());
            
            if ($formJob->isValid()) {
                $job->exchangeArray($formJob->getData());
                $this->jobTable->saveJob($job);
                $this->flashMessenger()->addMessage(array(
                    'success' => "Job '{$job->id_job}' was updated successfully"
                ));
                return $this->redirect()->toRoute('zfcadmin/job');
            } else {
                Debug::dump($formJob);
            }
        }
        
        $job = $this->jobTable->getJob($idJob);
        $formJob->setData($job->getArrayCopy());
        
        return new ViewModel(array(
            'form' => $formJob
        ));
    }

    public function deleteAction()
    {
        $flashMessenger = $this->getServiceLocator()->get('jobeet_flashmessenger');
        $idJob = $this->params()->fromRoute('id', null);
        $nbResult = $this->jobTable->deleteJob(array(
            'id_job = ?' => $idJob
        ));
        
        if ($nbResult >= 1) {
            $this->flashMessenger()->addMessage(array(
                'success' => "Job {$idJob} was deleted!"
            ));
        } else {
            $this->flashMessenger()->addMessage(array(
                'error' => "Job {$idJob} can't be deleted!"
            ));
        }
        
        return $this->redirect()->toRoute('zfcadmin/job');
    }
}
