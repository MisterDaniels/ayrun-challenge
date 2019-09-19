<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Response;

    class Homepage extends AbstractController {

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