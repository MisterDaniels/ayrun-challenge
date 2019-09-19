<?php

    namespace App\Controller;

    // Requests, Responses, Rotas e Controladores
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;

    // Dotenv
    use Symfony\Component\Dotenv\Dotenv;

    // AWS S3
    use Aws\S3\S3Client;
    use League\Flysystem\AwsS3v3\AwsS3Adapter;
    use League\Flysystem\Filesystem;

    // Database Doctrine communicator
    use App\Entity\Photo;
    use Doctrine\ORM\EntityManagerInterface;

    // Reference do .env file
    $dotenv = new Dotenv();
    $dotenv->load(__DIR__ . '/../../' . '/.env');

    // Controller de todos os métodos para upload
    class UploadController extends AbstractController {
        
        // Faz o upload dos arquivos, recebe url, sizes e copies através da URL
        /**
         * @Route(
         *  "/upload", 
         *  name="upload_files"
         * )
         */
        public function uploadFile(Request $request) {

            $url = $request->query->get('url');
            $sizes[] = $request->query->get('sizes');
            $copies = $request->query->get('copies');

            $s3Url = $this->uploadToS3($url);
            $database = $this->databaseRegistrate($s3Url, $sizes, $copies);

            return new Response(
                '<html><body>values: ' . $url . join(', ', $sizes) . $copies . $s3Url . $database . '</body></html>'
            );

        }

        // Faz o upload para o S3, só passa a url externa da imagem, 
        // baixa a imagem no servidor e faz upload para o S3, depois deleta a referência local do servidor
        public function uploadToS3(string $url) {

            $filePath = __DIR__ . '/../../uploads/photo' . md5(uniqid(rand(), true)) . '.jpg';
            $file = file_put_contents($filePath, file_get_contents($url));

            $client = new S3Client([
                'credentials' => [
                    'key'     => $_ENV['S3_KEY'],
                    'secret'  => $_ENV['S3_SECRET'],
                ],
                'region'      => $_ENV['S3_REGION'],
                'version'     => $_ENV['S3_VERSION']
            ]);

            $adapter = new AwsS3Adapter($client, 'auryn-challenge', 'photos');

            $result = $client->putObject([
                'Bucket'              => $_ENV['S3_BUCKET'],
                'Key'                 => 'photos/' . basename($filePath),
                'SourceFile'          => $filePath,
                'StorageClass'        => 'REDUCED_REDUNDANCY'
            ]);

            unlink($filePath);

            return $result['ObjectURL'];

        }

        // Registra os dados como a url da S3 já feito o upload, os tamanhos das fotos e a quantidade de cópias
        public function databaseRegistrate(string $url, Array $sizes, string $copies): Response {

            $entityManager = $this->getDoctrine()->getManager();

            $photo = new Photo();
            $photo->setUrl($url);
            $photo->setSizes($sizes);
            $photo->setCopies($copies);

            $entityManager->persist($photo);
            $entityManager->flush();

            return new Response ($photo->getId());

        }

    };