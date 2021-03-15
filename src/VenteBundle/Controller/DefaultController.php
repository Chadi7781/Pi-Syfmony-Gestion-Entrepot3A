<?php

namespace VenteBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/send-notification", name="send_notification")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function controllerFunctionAction(Mgilet\NotificationBundle\Manager\NotificationManager $manager)
    {
        $notif = $manager->createNotification('Nouveau candidat !');
        $notif->setMessage('X a entré un candidat');
        $notif->setLink('http://symfony.com/');
        $manager->addNotification(array($this->getUser()), $notif, true);

        return $this->redirectToRoute('ajouter');
    }
}
