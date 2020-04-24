<?php


namespace App\Controller;


use App\Entity\ShortenedUrl;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AppController
 * @package App\Controller
 */
class AppController extends AbstractController
{
    /**
     * @param mixed $id
     * @return ShortenedUrl
     */
    protected function findOrNotFound($id)
    {
        if (!is_int($id)) {
            throw $this->createNotFoundException();
        }

        $repository = $this->getDoctrine()
            ->getRepository(ShortenedUrl::class);

        try {
            /** @var ShortenedUrl $entity */
            $entity = $repository->findOneByIdNotExpired($id);

            return $entity;
        } catch (NoResultException $exception) {
            throw $this->createNotFoundException();
        }
    }
}