<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog/show")
 */
class BlogController extends AbstractController
{

    /**
     * @Route("/", name="blog_index")
     */
    public function index()
    {
        $slug = "Article Sans Titre";
        return $this->render('blog/show.html.twig', [
            'slug' => $slug
        ]);
    }

    /**
     * @Route("/{slug}", requirements={"slug" = "[a-z0-9-]+"}, methods={"GET"}, name="blog_slug")
     */
    public function show(string $slug)
    {
        $slug = str_replace('-', ' ', $slug);
        $slug = ucwords($slug);

        return $this->render('blog/show.html.twig', [
            'slug' => $slug
        ]);
    }


}
