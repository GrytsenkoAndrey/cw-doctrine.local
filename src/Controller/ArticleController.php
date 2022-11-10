<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
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

        if ($request->isPost()) {
            $article->setName($request->getParam('name'));
            $article->setImage($request->getParam('image'));
            $article->setBody($request->getParam('body'));

            $this->ci->get('db')->persist($article);
            $this->ci->get('db')->flush();

            return $response->withRedirect('/admin');
        }

        return $this->renderPage($response, 'article_edit.html', [
            'article' => $article
        ]);
    }

    public function create(Request $request, Response $response, array $args = [])
    {
        $article = new Article();

        if ($request->isPost()) {
            $article->setName($request->getParam('name'));
            $article->setSlug($request->getParam('slug'));
            $article->setImage($request->getParam('image'));
            $article->setBody($request->getParam('body'));

            $this->ci->get('db')->persist($article);
            $this->ci->get('db')->flush();
        }

        return $this->renderPage($response, 'article_create.html', [
            'article' => $article
        ]);
    }
}
