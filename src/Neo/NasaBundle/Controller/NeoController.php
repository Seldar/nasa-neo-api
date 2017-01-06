<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 5.12.2016
 * Time: 15:58
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Neo\NasaBundle\Controller;

use Neo\NasaBundle\Repository\NeoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class NeoController
 *
 * Controller to handle Neo related routes.
 *
 * @package Neo\NasaBundle\Controller
 */
class NeoController extends Controller
{
    /**
     * Holds the repository to change and reuse.
     *
     * @var NeoRepository
     */
    private $neoRepository;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->setRepository($this->get('doctrine_mongodb')->getManager()->getRepository('NasaBundle:Neo'));
    }

    /**
     * Sets the repository for testing purposes.
     *
     * @param NeoRepository $repository
     */
    public function setRepository(NeoRepository $repository)
    {
        $this->neoRepository = $repository;
    }

    /**
     * Returns Json represenation of hazardous neo's from the database
     *
     * @Route("/neo/hazardous")
     */
    public function listHazardous()
    {

        return new JsonResponse($this->neoRepository->getHazardousNeo());
    }

    /**
     * Returns Json representation of fastest neo from the database
     *
     * @Route("/neo/fastest")
     */
    public function getFastest()
    {
        return new JsonResponse($this->neoRepository->getFastestNeo());
    }
}