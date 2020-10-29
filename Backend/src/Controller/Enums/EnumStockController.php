<?php

namespace App\Controller\Enums;

use App\Serializer\FormErrorSerializer;
use Behat\Behat\HelperContainer\Exception\NotFoundException;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;

/**
 * Class EnumStockController
 * @package App\Controller\Enums
 * 
 * @Route("api/ingredient/stock")
 * @SWG\Tag(name="Ingredients' enums")
 */
class EnumStockController extends AbstractFOSRestController
{
    /**
     * @Route("/enum/{name}",
     *  name="api_enum_ingredient_stock_get",
     *  methods={"GET"},
     *  requirements={
     *      "name": "(states|headers)"
     * })
     * 
     * @SWG\Get(
     *  summary="Récupère les valeurs possible des énumérations States ou Header du stock.",
     *  produces={"application/json"},
     *  @SWG\Parameter(
     *          name="name",
     *          type="string",
     *          required=true,
     *          description="On cherche soit la liste des états du stock soit la liste de tout les entêtes possible.",
     *          in="path")
     * )
     * @SWG\Response(
     *  response=200,
     *  description="L'enum a bien été récupéré.",
     *  @SWG\Schema(type="array",
     *      @SWG\Items(type="enum", enum="{'{ordered, created}', '{name, quantity}'}"))
     * )
     * @SWG\Response(
     *  response=404,
     *  description="L'enum n'a pas été trouvé."
     * )
     * @param string $name
     * @return View
     * @throws NotFoundException
     */
    public function getEnumsAction(string $name)
    {
        switch ($name) {
            default:
                break;
        }
        throw new NotFoundException();
    }
}
