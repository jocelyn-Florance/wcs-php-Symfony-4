<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog/show", name="blog_show")
 */
class BlogController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function index()
    {
        $slug = "Article Sans Titre";
        return $this->render('blog/show.html.twig', [
            'slug' => $slug
        ]);
    }

    /**
     * @Route("/{slug}", requirements={"slug" = "[a-z0-9-]+"}, name="_slug")
     */
    public function show($slug)
    {
        $slug = str_replace('-', ' ', $slug);
        $slug = ucwords($slug);

        return $this->render('blog/show.html.twig', [
            'slug' => $slug
        ]);
    }


}
