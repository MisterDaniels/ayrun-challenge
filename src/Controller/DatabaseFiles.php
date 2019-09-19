<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    // Database Doctrine communicator
    use App\Entity\Photo;
    use Doctrine\ORM\EntityManagerInterface;

    class DatabaseFiles extends AbstractController {

        /**
         * @Route(
         *  "/api/photo",
         *  name="photo"
         * )
         */
        public function getFilesTotal() {

            $photos = $this->getDoctrine()
                ->getRepository(Photo::class)
                ->findAll();

            return new Response (json_encode(['size' => sizeof($photos, 201)]));    

        }

        /**
         * @Route(
         *  "/api/photo/{id}",
         *  name="photo_getter"
         * )
         */
        public function getFile($id) {

            $photo = $this->getDoctrine()
                ->getRepository(Photo::class)
                ->find($id);
            
            return new Response(json_encode(
                ['url' => $photo->getUrl(),
                'sizes' => array (
                    $photo->getSizes()
                ),
                'copies' => $photo->getCopies()
            ]));

        }

    }