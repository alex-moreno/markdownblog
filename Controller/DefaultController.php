<?php

namespace SymblogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SymblogBundle:Default:index.html.twig', array('name' => $name));
    }
}
