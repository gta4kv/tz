<?php

namespace App\Controller;

use App\Entity\ShortenedUrl;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class RedirectController
 * @package App\Controller
 */
class RedirectController extends AppController
{
    /**
     * @Route("/r/{id}", name="redirect_url")
     * @ParamConverter("id", options={"hashid" = "id"})
     *
     * @param string $id
     * @return Response
     */
    public function act($id)
    {
        /** @var ShortenedUrl $entity */
        $entity = $this->findOrNotFound($id);

        return $this->redirect($entity->getUrl());
    }
}