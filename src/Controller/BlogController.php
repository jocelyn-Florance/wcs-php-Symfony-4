<?php

namespace App\Controller;

use App\Entity\Article;

use App\Entity\Categorys;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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

        $category = $this->getDoctrine()
            ->getRepository(Categorys::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        return $this->render('home.html.twig', [
            'articles' => $articles,
            'categorys' => $category
        ]);
    }

    /**
     * @Route("/blog/show/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="blog_show")
     * @param string|null $slug
     * @return Response
     */
    public function show(?string $slug): Response
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
                'No article with ' . $slug . ' title, found in article\'s table.'
            );
        }

        return $this->render('blog/show.html.twig', [
            'article' => $article,
            'slug' => $slug,
        ]);
    }

    /**
     * @Route("/blog/category/{name}", name="blog_show_category").
     * @return Response
     */
    public function showByCategory(Categorys $category): Response
    {
        $articles = $category->getArticles();

        return $this->render('blog/category.html.twig', [
            'articles' => $articles,
            'category' => $category
        ]);
    }


}
