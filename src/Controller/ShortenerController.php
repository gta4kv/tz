<?php

namespace App\Controller;

use App\Entity\ShortenedUrl;
use App\Form\Type\CreateUrlType;
use Exception;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Hashids\HashidsInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ShortenerController
 * @package App\Controller
 */
class ShortenerController extends AppController
{
    /**
     * @var HashidsInterface|null
     */
    private $idHasher = null;

    /**
     * ShortenerController constructor.
     * @param HashidsInterface $idHasher
     */
    public function __construct(HashidsInterface $idHasher)
    {
        $this->idHasher = $idHasher;
    }

    /**
     * @Route("/", name="create_url")
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        $shortenedUrl = new ShortenedUrl();

        $form = $this->createForm(CreateUrlType::class, $shortenedUrl);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->saveShortenedUrl($shortenedUrl);

            return $this->redirectToRoute('view_url', [
                'id' => $shortenedUrl->getHash()
            ]);
        }

        return $this->render('shortener/create.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/v/{id}", name="view_url")
     * @ParamConverter("id", options={"hashid" = "id"})
     *
     * @param string $id
     * @return Response
     */
    public function view($id)
    {
        $entity = $this->findOrNotFound($id);


        return $this->render('shortener/view.twig', [
            'entity' => $entity
        ]);
    }

    /**
     * @param ShortenedUrl $url
     * @throws Exception
     */
    private function saveShortenedUrl(ShortenedUrl &$url)
    {
        if ($url->getLifetime() !== null && $url->getLifetime()->getDurationHours() !== null) {
            $url->setExpiresAt((new \DateTime())
                ->add(new \DateInterval('PT' . $url->getLifetime()->getDurationHours() . 'H')));
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($url);

        $url->setHash(
            $this->idHasher->encode($url->getId())
        );

        $entityManager->persist($url);
        $entityManager->flush();
    }
}