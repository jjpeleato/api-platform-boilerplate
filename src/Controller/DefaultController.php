<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController extends AbstractController
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $environment = $this->getParameter('APP_ENV');
        $appKey = $this->getParameter('APP_KEY');
        return $this->render(
            'base.html.twig',
            [
                'environment' => $environment,
                'app_key' => $appKey,
            ]
        );
    }
}
