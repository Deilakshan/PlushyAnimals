<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(): Response
    {
        
        // Keep your Stripe API key protected by including it as an environment variable
        // or in a private script that does not publicly expose the source code.

        // This is your test secret API key.
        $stripeSecretKey = 'sk_test_51N6bMlEjK2gcrXBYzYGAbHQS3AfORGepqYUxWx0f5kXaG5AELQodyY3gMDl6Ly9TZ6W4rdTtCe9ss5xBk4yBUvzY00C0megwmc';

        // require_once '../vendor/autoload.php';
        // require_once '../secrets.php';

        \Stripe\Stripe::setApiKey($stripeSecretKey);
        header('Content-Type: application/json');

        $YOUR_DOMAIN = 'http://localhost:4242';

        $checkout_session = \Stripe\Checkout\Session::create([
        'line_items' => [[
            # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
            'price' => '{{prix_id}}',
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $YOUR_DOMAIN . '/success.html',
        'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        ]);

        header("HTTP/1.1 303 See Other");
        header("Location: " . $checkout_session->url);





        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }
}
