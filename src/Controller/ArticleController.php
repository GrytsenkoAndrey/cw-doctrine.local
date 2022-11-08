<?php
declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ArticleController
{
    public function index(Request $request, Response $response, array $args = [])
    {
        $article = $this->ci->get('db')
            ->getRepository('App\Entity\Article')
            ->findOneBy([
                'slug' => $args['slug']
            ]);

        if (! $article) {
            throw new HttpNotFoundException();
        }

        return $this->renderPage($response, 'article.html', [
            'article' => $article
        ]);
    }

    public function viewPk(Request $request, Response $response)
    {
        $article = $this->ci->get('db')->find('App\Entity\Article', 1);

        return $this->renderPage($response, 'article.html', [
            'article' => $article
        ]);
    }

    public function viewQb(Request $request, Response $response, array $args = [])
    {
        $qb = $this->ci->get('db')
            ->createQueryBuilder();
        $qb->select('a')
            ->from('App\Entity\Article', 'a')
            ->where('a.slug = :slug')
            ->setParameter('slug', $args['slug']);

        $query = $qb->getQuery();
        $article = $query->getSingleResult();

        var_dump($article);
    }

    public function edit(Request $request, Response $response, array $args = [])
    {
        $article = $this->ci->get('db')->find('App\Entity\Article', [$args['id']]);

        if (! $article) {
            throw new HttpNotFoundException();
        }

        return $this->renderPage($response, 'article_edit.html', [
            'article' => $article
        ]);
    }
}
