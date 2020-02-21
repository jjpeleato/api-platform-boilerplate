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
    public function index()
    {
        $environment = $this->getParameter('APP_ENV');
        $appSecret = $this->getParameter('APP_SECRET');
        return $this->render(
            'base.html.twig',
            [
                'environment' => $environment,
                'app_secret' => $appSecret,
            ]
        );
    }
}
