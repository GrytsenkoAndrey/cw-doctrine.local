<?php
declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DefaultController
{
    public function homepage(Request $request, Response $response)
    {
        $articles = $this->ci
            ->get('db')
            ->getRepository('App\Entity\Article')
            ->findBy([], [
                'published' => 'DESC'
            ]);

        return $this->renderPage($response, 'homepage.html', [
            'article' => $articles
        ]);
    }
}
