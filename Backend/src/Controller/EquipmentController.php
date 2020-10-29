<?php

namespace App\Controller;

use App\Entity\Equipment;
use App\Form\EquipmentType;
use App\Repository\EquipmentRepository;

use App\Controller\Helpers\HelperController;
use App\Controller\Helpers\HelperForwardController;

use App\Serializer\FormErrorSerializer;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;
use DateTime;

/**
 * Class EquipmentController
 * @package App\Controller
 *
 * Je spécifie que toute les entrées HTTP qui sont définies dans ce fichier auront comme préfix /api
 * ce qui donne une URL de ce genre: http://URL:PORT/api/XXX
 *
 * @Route("api")
 * @SWG\Tag(
 * name="EquipmentController"
 * )
 *
 */
class EquipmentController extends AbstractFOSRestController
{
    /**
     * Utilise les fonctionnalités écritent dans HelperController.
     */
    use HelperController;

    /**
     * Utilise les fonctionnalités écritent dans HelperForwardController.
     */
    use HelperForwardController;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var EquipmentRepository
     */
    private $repository;

    /**
     * @var FormErrorSerializer
     */
    private $formErrorSerializer;

    private $brand = "brand";
    private $category = "category";

    public function __construct(
        EntityManagerInterface $entityManager,
        EquipmentRepository $repository,
        FormErrorSerializer $formErrorSerializer
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->formErrorSerializer = $formErrorSerializer;
    }

    /**
     * @Route("/equipment",
     * name="api_equipment_post",
     * methods={"POST"}
     * )
     *
     * @SWG\Post(
     * consumes={"application/json"},
     * produces={"application/json"},
     * summary="Crée un nouvel Equipment",
     * @SWG\Response(
     * response=201,
     * description="Le Equipment a bien été inséré.",
     * @SWG\Schema(ref=@Model(type=Equipment::class))
     * ),
     * @SWG\Response(
     * response=422,
     * description="Le JSON comporte une erreur.<br />Regarde la réponse, elle en dira plus."
     * ),
     * @SWG\Response(
     * response=404,
     * description="L'enfant CHILDREN n'existe pas."
     * ),
     * @SWG\Parameter(
     * name="Le Equipment au format JSON.",
     * in="body",
     * required=true,
     * @SWG\Schema(ref=@Model(type=Equipment::class))
     * )
     * )
     * @param Request $request
     * @return View|JsonResponse
     * @throws ExceptionInterface
     */
    public function postAction(Request $request)
    {
        $data = $this->getDataFromJson($request, true);
        $responseChildren[] = $this->createOrUpdate($data, $this->category, "Category");
        $responseChildren[] = $this->createOrUpdate($data, $this->brand, "Brand");
        $newEntity = new Equipment();

        $form = $this->createForm(EquipmentType::class, $newEntity);
        $form->submit($data, false);

        $this->validationError(
            $form,
            $this,
            $responseChildren
        );

        $insertData = $form->getData();
        $this->entityManager->persist($insertData);

        $this->entityManager->flush();
        return $this->view($insertData, Response::HTTP_CREATED);
    }

    /**
     * @Route("/equipment/{id}",
     * name="api_equipment_get",
     * methods={"GET"},
     * requirements={
     * "id": "\d+"
     * })
     *
     * @SWG\Get(
     * summary="Donne les informations de Equipment.",
     * produces={"application/json"}
     * )
     * @SWG\Response(
     * response=200,
     * description="Le Equipment a bien été trouvé.",
     * @SWG\Schema(ref=@Model(type=Equipment::class))
     * )
     *
     * @SWG\Response(
     * response=404,
     * description="Le Equipment n'existe pas encore."
     * )
     * @param string $id
     * @return View
     */
    public function getAction(string $id)
    {
        return $this->view($this->getById($id));
    }

    /**
     * @Route("/equipments",
     * name="api_equipment_gets",
     * methods={"GET"})
     *
     * @SWG\Get(
     * summary="Retourne la liste de tout le Equipment.",
     * produces={"application/json"}
     * )
     * @SWG\Response(
     * response=200,
     * description="Retourne une JSON liste de tout le Equipment.",
     * @SWG\Schema(ref=@Model(type=Equipment::class))
     * )
     *
     * @QueryParam(name="page"
     * , requirements="\d+"
     * , default="1"
     * , description="La page en cours.")
     * @QueryParam(name="limit"
     * , requirements="\d+"
     * , default="0"
     * , description="Le nombre de ligne du Equipment à retourner dans la liste. 0 pour tous.")
     * @QueryParam(name="sort"
     * , requirements="(asc|desc)"
     * , allowBlank=false
     * , default="asc"
     * , description="La direction du tri.")
     * @QueryParam(name="sortBy"
     * , requirements="(id)"
     * , default="state"
     * , description="Le tri est organisé sur les attributs de la classe.")
     * @QueryParam(name="search"
     * , nullable=true
     * , description="Recherche dans la base sur les attributs de la classe.")
     *
     * @param ParamFetcher $paramFetcher
     * @return View
     */
    public function getAllAction(ParamFetcher $paramFetcher)
    {
        $list = $this->repository->findAllPagination($paramFetcher);
        return $this->setPaginateToView($list, $this);
    }

    /**
     * @Route("/equipment/{id}",
     * name="api_equipment_patch",
     * methods={"PATCH"},
     * requirements={
     * "id": "\d+"
     * })
     *
     * @SWG\Patch(
     * summary="Mise à jour d'une partie de Equipment. Les champs manquants ne sont pas modifiés.",
     * consumes={"application/json"},
     * produces={"application/json"},
     * @SWG\Response(
     * response=204,
     * description="La mise à jour s'est terminée avec succès."
     * ),
     * @SWG\Response(
     * response=422,
     * description="Le JSON n'est pas correct ou il y a un problème avec un champs.<BR />
     * Regarde la réponse pour avoir plus d'information."
     * ),
     * @SWG\Parameter(
     * name="JSON de Equipment.",
     * in="body",
     * required=true,
     * @SWG\Schema(ref=@Model(type=Equipment::class)),
     * description="Une partie de Equipment."
     * ),
     * @SWG\Response(
     * response=404,
     * description="Le Equipment n'a pas été trouvée."
     * ),
     * @SWG\Parameter(
     * name="id",
     * in="path",
     * type="string",
     * description="L'ID utilisé pour retrouver le Equipment."
     * )
     * )
     * @param string $id
     * @param Request $request
     * @return View|JsonResponse
     * @throws ExceptionInterface
     */
    public function patchAction(Request $request, string $id)
    {
        return $this->putOrPatch($this->getDataFromJson($request, true), false, $id);
    }

    /**
     * @param array $data
     * @param string $id
     * @param bool $clearMissing
     * @return View|JsonResponse
     * @throws ExceptionInterface
     * @throws Exception
     */
    public function putOrPatch(array $data, bool $clearMissing, string $id)
    {
        $existing = $this->getById($id);
        $responseChildren[] = $this->createOrUpdate($data, $this->category, "Category");
        $responseChildren[] = $this->createOrUpdate($data, $this->brand, "Brand");
        $form = $this->createForm(Equipment::class, $existing);

        $form->submit($data, $clearMissing);
        $this->validationError($form, $this, $responseChildren);

        $this->entityManager->flush();

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/equipment/{id}",
     * name="api_equipment_delete",
     * methods={"DELETE"},
     * requirements={
     * "id": "\d+"
     * })
     *
     * @SWG\Delete(
     * summary="Supprime le Equipment de la base de données. Ne peut pas être annulé.",
     * @SWG\Parameter(
     * name="id",
     * in="path",
     * type="string",
     * description="L'ID utilisé pour retrouver le Equipment."
     * )
     * )
     * @SWG\Response(
     * response=204,
     * description="Le Equipment a bien été supprimé."
     * )
     *
     * @SWG\Response(
     * response=404,
     * description="Le Equipment n'existe pas."
     * )
     *
     * @param string $id
     * @throws Exception
     * @return View|JsonResponse
     */
    public function deleteAction(string $id)
    {
        $existing = $this->getById($id);

        $this->entityManager->remove($existing);
        $this->entityManager->flush();
        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param string $id
     *
     * @return Ingredient
     * @throws NotFoundHttpException
     */
    private function getById(string $id)
    {
        $data = $this->repository->find($id);
        if (null === $data) {
            throw new NotFoundHttpException();
        }
        return $data;
    }
}
