<?php

namespace App\Controller;

use App\Entity\Article;

use App\Entity\Categorys;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{

    /**
     * @Route("/", name="blog_index")
     */
    public function index()
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        return $this->render('home.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/show/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="blog_show")
     * @param string|null $slug
     * @return Response
     */
    public function show(?string $slug) : Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with '.$slug.' title, found in article\'s table.'
            );
        }

        return $this->render('blog/show.html.twig', [
            'article' => $article,
            'slug' => $slug,
        ]);
    }

    /**
     * @Route("/category/{category}", name="blog_show_category").
     * @param string $category
     * @return Response
     */
    public function showByCategory(string $category) : Response
    {
        $repositoryCategory = $this->getDoctrine()->getRepository(Categorys::class);
        $category = $repositoryCategory->findOneByName($category);

        $repositoryArtilce = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repositoryArtilce->findByCategory($category);

        return $this->render('blog/category.html.twig', [
            'articles' => $articles,
        ]);
    }


}
