<?php

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\RouteCollectionBuilder;

class JiraDummyKernel extends Kernel
{
    use MicroKernelTrait;

    private $projects = [
        'DBAL' => 'dbal',
        'DDC' => 'doctrine2',
        'DMIG' => 'migrations',
        'DCOM' => 'common',
        'CODM' => 'couchdb-odm',
        'MODM' => 'mongodb-odm',
    ];

    public function registerBundles()
    {
        return array(new Symfony\Bundle\FrameworkBundle\FrameworkBundle());
    }

    public function boot()
    {
        parent::boot();

        $eventDispatcher = $this->getContainer()->get('event_dispatcher');
        $eventDispatcher->addListener('kernel.exception', [$this, 'onException']);
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->add('/projects/{project}', 'kernel:projectRedirectAction');
        $routes->add('/browse/{issue}', 'kernel:issueRedirectAction');
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader)
    {
        $container->loadFromExtension('framework', ['secret' => md5(microtime(true))]);
    }

    public function projectRedirectAction($project)
    {
        if (!isset($this->projects[$project])) {
            throw new NotFoundHttpException();
        }

        return new RedirectResponse('https://github.com/doctrine/' . $this->projects[$project] . '/issues');
    }

    public function issueRedirectAction($issue)
    {
        $issueMap = json_decode(file_get_contents(__DIR__ . "/../config/issues.json"), true);

        if (!isset($issueMap[$issue]) || strpos($issue, "-") === false) {
            throw new NotFoundHttpException();
        }

        list($project, $number) = explode('-', $issue);

        return new RedirectResponse('https://github.com/doctrine/' . $this->projects[$project] . '/issues/' . $issueMap[$issue]['id']);
    }

    public function onException($event)
    {
        $exception = $event->getException();
        $statusCode = ($exception instanceof HttpException) ? $exception->getStatusCode() : 500;

        $content = file_get_contents(__DIR__ . "/../templates/notfound.html");
        $event->setResponse(new Response($content, $statusCode));
    }
}
