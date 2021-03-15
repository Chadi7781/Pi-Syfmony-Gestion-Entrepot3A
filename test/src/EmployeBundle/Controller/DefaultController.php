<?php

namespace EmployeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EmployeBundle:Default:index.html.twig');
    }
}
