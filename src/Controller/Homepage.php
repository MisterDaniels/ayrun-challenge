<?php

    namespace App\Controller;

    // Responses, Rotas e Controladores
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Response;

    // Só para trabalhar com a home
    class Homepage extends AbstractController {

        // Renderiza o arquivo estático        
        /**
         * @Route(
         *  "/",
         *  name="homepage"
         * )
         */
        public function getHomepage() {
            return $this->render('home.html.twig');
        }

    }