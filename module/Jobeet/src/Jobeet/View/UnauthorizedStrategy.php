<?php
namespace Jobeet\View;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Response as HttpResponse;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ResponseInterface as Response;

class UnauthorizedStrategy implements ListenerAggregateInterface
{

    /**
     *
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, array(
            $this,
            'onDispatchError'
        ), - 5000);
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function onDispatchError(MvcEvent $e)
    {
        // Do nothing if the result is a response object
        $result = $e->getResult();
        if ($result instanceof Response) {
            return;
        }
        
        $app = $e->getTarget();
        $serviceManager = $app->getServiceManager();
        
        $router = $e->getRouter();
        $match = $e->getRouteMatch();
        
        $routeName = $match->getMatchedRouteName();
        
        $module = $serviceManager->get('ModuleManager')->getModule('Jobeet');
        
        $adminRoute = $module->getOption('routes.backend');
        $adminLoginRoute = $module->getOption('routes.backend-login');
        
        $frontRoute = $module->getOption('routes.frontend');
        $frontLoginRoute = $module->getOption('routes.frontend-login');
        
        if ($routeName === $adminLoginRoute || $routeName === $frontLoginRoute) {
            return;
        }
        
        if (strpos($routeName, $adminRoute) === 0) {
            $loginRoute = $adminLoginRoute;
        } elseif (strpos($routeName, $frontRoute) === 0) {
            $loginRoute = $frontLoginRoute;
        } else {
            return;
        }
        
        // get url to the zfcuser/login route
        $options['name'] = $loginRoute;
        $url = $router->assemble(array(), $options);
        
        // Work out where were we trying to get to
        $options['name'] = $match->getMatchedRouteName();
        $redirect = $router->assemble($match->getParams(), $options);
        
        // set up response to redirect to login page
        $response = $e->getResponse();
        if (! $response) {
            $response = new HttpResponse();
            $e->setResponse($response);
        }
        $response->getHeaders()->addHeaderLine('Location', $url . '?redirect=' . $redirect);
        $response->setStatusCode(302);
    }
}