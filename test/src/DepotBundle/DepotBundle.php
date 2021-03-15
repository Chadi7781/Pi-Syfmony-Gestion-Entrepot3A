<?php

namespace DepotBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DepotBundle extends Bundle
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $depots = $em->getRepository('DepotBundle:Depot')->findAll();

        return $this->render('@Depot/index.html.twig', array(
            'depots' => $depots,
        ));
    }
}
