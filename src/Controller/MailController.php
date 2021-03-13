<?php

namespace App\Controller;
// require '../vendor/autoload.php';
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Mailjet\Resources;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MailController extends AbstractController
{
    /**
     * @Route("/commandeSucces", name="commandeSucces")
     */
 function commandeSucces( SessionInterface $session): Response
    {
        $user = $this->getUser();
        $mail = $user->getEmail();
        $nom = $user->getNom();
 
        $mj = new \Mailjet\Client('e0a820e2f23f02e9cb67f468f2226f9a','aba302cfbeeeb638127e188871224dce',true,['version' => 'v3.1']);
        $body = [
          'Messages' => [
            [
              'From' => [
                'Email' => "hophelie.bourgeois17@gmail.com",
                'Name' => "Hophelie"
              ],
              'To' => [
                [
                  'Email' => $mail,
                  'Name' => $nom
                ]
              ],
              'Subject' => "Greetings from Mailjet.",
              'TextPart' => "My first Mailjet email",
              'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href='https://www.mailjet.com/'>Mailjet</a>!</h3><br />May the delivery force be with you!",
              'CustomID' => "AppGettingStartedTest"
            ]
          ]
        ];
        
        $session->set('panier', []); 
        
      
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && dump($response->getData());
        return $this->render('commande/commandeSucces.html.twig');
    }
}
