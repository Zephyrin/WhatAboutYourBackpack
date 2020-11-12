<?php

namespace App\Controller;

use App\Entity\Characteristic;
use App\Form\CharacteristicType;
use App\Repository\CharacteristicRepository;

use App\Controller\Helpers\HelperController;
use App\Controller\Helpers\HelperForwardController;
use App\Repository\EquipmentRepository;
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
 * Class CharacteristicController
 * @package App\Controller
 *
 * Je spécifie que toute les entrées HTTP qui sont définies dans ce fichier auront comme préfix /api
 * ce qui donne une URL de ce genre: http://URL:PORT/api/XXX
 *
 * @Route("api")
 * @SWG\Tag(
 * name="CharacteristicController"
 * )
 *
 */
class CharacteristicController extends AbstractFOSRestController
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
     * @var CharacteristicRepository
     */
    private $repository;
    /**
     * @var EquipmentRepository
     */
    private $equipmentRepository;

    /**
     * @var FormErrorSerializer
     */
    private $formErrorSerializer;

    public function __construct(
        EntityManagerInterface $entityManager,
        CharacteristicRepository $repository,
        EquipmentRepository $equipmentRepository,
        FormErrorSerializer $formErrorSerializer
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->equipmentRepository = $equipmentRepository;
        $this->formErrorSerializer = $formErrorSerializer;
    }

    /**
     * @Route("/equipment/{eqId}/characteristic",
     * name="api_characteristic_post",
     * methods={"POST"},
     * requirements={
     *  "eqId": "\d+"
     * })
     *
     * @SWG\Post(
     * consumes={"application/json"},
     * produces={"application/json"},
     * summary="Crée un nouvel Characteristic",
     * @SWG\Response(
     * response=201,
     * description="Le Characteristic a bien été inséré.",
     * @SWG\Schema(ref=@Model(type=Characteristic::class))
     * ),
     * @SWG\Response(
     * response=422,
     * description="Le JSON comporte une erreur.<br />Regarde la réponse, elle en dira plus."
     * ),
     * @SWG\Parameter(
     * name="Le Characteristic au format JSON.",
     * in="body",
     * required=true,
     * @SWG\Schema(ref=@Model(type=Characteristic::class))
     * )
     * )
     * @param Request $request
     * @param string $eqId
     * @return View|JsonResponse
     * @throws ExceptionInterface
     */
    public function postAction(Request $request, string $eqId)
    {
        $data = $this->getDataFromJson($request, true);
        $equipment = $this->getEquipmentById($eqId);
        $data['equipment'] = $equipment->getId();
        $newEntity = new Characteristic();

        $form = $this->createForm(CharacteristicType::class, $newEntity);
        $form->submit($data, false);
        $this->validationError(
            $form,
            $this
        );

        $insertData = $form->getData();
        $equipment->addCharacteristic($insertData);
        $this->entityManager->persist($insertData);

        $this->entityManager->flush();
        return $this->view($insertData, Response::HTTP_CREATED);
    }

    /**
     * @Route("/characteristic/{id}",
     * name="api_characteristic_get",
     * methods={"GET"},
     * requirements={
     * "id": "\d+"
     * })
     *
     * @SWG\Get(
     * summary="Donne les informations de Characteristic.",
     * produces={"application/json"}
     * )
     * @SWG\Response(
     * response=200,
     * description="Le Characteristic a bien été trouvé.",
     * @SWG\Schema(ref=@Model(type=Characteristic::class))
     * )
     *
     * @SWG\Response(
     * response=404,
     * description="Le Characteristic n'existe pas encore."
     * )
     * @param string $id
     * @return View
     */
    public function getAction(string $id)
    {
        return $this->view($this->getById($id));
    }

    /**
     * @Route("/characteristics",
     * name="api_characteristic_gets",
     * methods={"GET"})
     *
     * @SWG\Get(
     * summary="Retourne la liste de tout le Characteristic.",
     * produces={"application/json"}
     * )
     * @SWG\Response(
     * response=200,
     * description="Retourne une JSON liste de tout le Characteristic.",
     * @SWG\Schema(ref=@Model(type=Characteristic::class))
     * )
     *
     * @QueryParam(name="page"
     * , requirements="\d+"
     * , default="1"
     * , description="La page en cours.")
     * @QueryParam(name="limit"
     * , requirements="\d+"
     * , default="0"
     * , description="Le nombre de ligne du Characteristic à retourner dans la liste. 0 pour tous.")
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
     * @Route("/equipment/{eqId}/characteristic/{id}",
     * name="api_characteristic_patch",
     * methods={"PATCH"},
     * requirements={
     * "id": "\d+",
     * "eqId": "\d+"
     * })
     *
     * @SWG\Patch(
     * summary="Mise à jour d'une partie de Characteristic. Les champs manquants ne sont pas modifiés.",
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
     * name="JSON de Characteristic.",
     * in="body",
     * required=true,
     * @SWG\Schema(ref=@Model(type=Characteristic::class)),
     * description="Une partie de Characteristic."
     * ),
     * @SWG\Response(
     * response=404,
     * description="Le Characteristic n'a pas été trouvée."
     * ),
     * @SWG\Parameter(
     * name="id",
     * in="path",
     * type="string",
     * description="L'ID utilisé pour retrouver le Characteristic."
     * )
     * )
     * @param string $id
     * @param string $eqId
     * @param Request $request
     * @return View|JsonResponse
     * @throws ExceptionInterface
     */
    public function patchAction(Request $request, string $id, string $eqId)
    {
        $eq = $this->getEquipmentById($eqId);
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
        $form = $this->createForm(CharacteristicType::class, $existing);

        $form->submit($data, $clearMissing);
        $this->validationError($form, $this);
        $this->entityManager->flush();

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/characteristic/{id}",
     * name="api_characteristic_delete",
     * methods={"DELETE"},
     * requirements={
     * "id": "\d+"
     * })
     *
     * @SWG\Delete(
     * summary="Supprime le Characteristic de la base de données. Ne peut pas être annulé.",
     * @SWG\Parameter(
     * name="id",
     * in="path",
     * type="string",
     * description="L'ID utilisé pour retrouver le Characteristic."
     * )
     * )
     * @SWG\Response(
     * response=204,
     * description="Le Characteristic a bien été supprimée."
     * )
     *
     * @SWG\Response(
     * response=404,
     * description="Le Characteristic n'existe pas."
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
     * @return Characteristic
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

    /**
     * @param string $id
     *
     * @return Equipment
     * @throws NotFoundHttpException
     */
    private function getEquipmentById(string $id)
    {
        $data = $this->equipmentRepository->find($id);
        if (null === $data) {
            throw new NotFoundHttpException();
        }
        return $data;
    }
}
