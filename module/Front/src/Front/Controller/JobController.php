<?php
	namespace Front\Controller;
	
	use Jobeet\Controller\JobeetController;
	use Jobeet\Form\JobForm;
	use Jobeet\Model\Job;
	use Zend\Validator\File\Size;
	use Zend\View\Model\ViewModel;
	
	class JobController extends JobeetController
	{
	    public function indexAction()
	    {
	        return new ViewModel();
	    }
	
	    public function getAction()
	    {
	        $id_job = $this->params()->fromRoute('id', null);
	
	        if (!is_null($id_job)) {
	            $job = $this->jobTable->getJob($id_job);
	            $category = $this->categoryTable->getCategoryById($job->id_category);
	
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
	        $formJob = new JobForm($this->categoryTable);
	        $request = $this->getRequest();
	        
	        if ($request->isPost()) {
	            $job = new Job();
	            $formJob->setInputFilter($job->getInputFilter());
	            
	            $nonFiles = $this->getRequest()->getPost()->toArray();
	            $files = $this->getRequest()->getFiles()->toArray();
	            
	            $data = array_merge_recursive(
	                $nonFiles,
	                $files
	            );
	            
	            $formJob->setData($data);
	        
	            if ($formJob->isValid()) {
	                $size = new Size(array('max' => 716800));
	                $adapter = new \Zend\File\Transfer\Adapter\Http();
	                $adapter->setValidators(array($size), $files['logo']);
	
	                if (!$adapter->isValid()){
	                    $dataError = $adapter->getMessages();
	                    $error = array();
	                    foreach($dataError as $key => $row) {
	                        $error[] = $row;
	                    }
	                    $formJob->setMessages(array('logo' => $error ));
	                } else {
	                	$adapter->setDestination('./public/resources');
	                	
	                    if ($adapter->receive($files['logo']['name'])) {
	                        $job->exchangeArray($formJob->getData());
	                        $job->logo = $files['logo']['name'];
	
	                        $this->jobTable->saveJob($job);
	                        return $this->redirect()->toRoute('home');
	                    }
	                }
	            }
	        }
	        
	        return new ViewModel(
	            array(
	                'form' => $formJob
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
