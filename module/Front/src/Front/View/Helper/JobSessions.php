<?php
namespace Front\View\Helper;

use \Jobeet\Filter\Slugify as Slugify;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\Session\Container;
use Zend\View\Helper\AbstractHelper;

class JobSessions extends AbstractHelper implements ServiceLocatorAwareInterface
{
    public function __invoke()
    {
        $slug = new Slugify();
        $job_sessions = new Container('jobs');

        $html = '';
        if (isset($job_sessions->jobs)) {
            $html .= '<ul>';
            $jobTable = $this->serviceLocator->getServiceLocator()->get('Jobeet\Model\JobTable');

            $getUrl = $this->getView()->plugin('url');

            foreach ($job_sessions->jobs as $key => $idJob) {
                $currentJob = $jobTable->getJob((int)$idJob);

                if (!is_null($currentJob))
                {
                    $url = $getUrl(
                        'home/get_job',
                        array(
                            'company' => $slug->filter($currentJob->company),
                            'position' => $slug->filter($currentJob->position),
                            'location' => $slug->filter($currentJob->location),
                            'id' => $currentJob->id_job
                        ),
                        false,
                        false
                    );

                    $html .= '<li><a href="' . $url . '">' . $currentJob->position . ' - ' . $currentJob->company . '</a></li>';
                }
            }
            $html .= '<ul>';
        }

        return $html;
    }

    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}
