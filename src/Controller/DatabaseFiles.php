<?php

    namespace App\Controller;

    // Responses, Rotas e Controladores
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    // Database Doctrine communicator
    use App\Entity\Photo;
    use Doctrine\ORM\EntityManagerInterface;

    // Apenas para coletar as informaçõe do banco de dados
    class DatabaseFiles extends AbstractController {

        // Retorna um JSON da quantidade de fotos no banco        
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

        // Retorna um JSON de uma foto específica
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