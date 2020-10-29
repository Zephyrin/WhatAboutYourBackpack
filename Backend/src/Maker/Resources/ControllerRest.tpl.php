<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

use App\Entity\<?= $entity_name ?>;
use App\Form\<?= $entity_name ?>Type;
use App\Repository\<?= $entity_name ?>Repository;

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
* Class <?= $class_name; ?><?= "\n" ?>
* @package App\Controller
*
* Je spécifie que toute les entrées HTTP qui sont définies dans ce fichier auront comme préfix /api
* ce qui donne une URL de ce genre: http://URL:PORT/api/XXX
*
* @Route("api")
* @SWG\Tag(
* name="<?= $class_name; ?>"
* )
*
*/
class <?= $class_name; ?> extends AbstractFOSRestController
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
* @var <?= $entity_name ?>Repository
*/
private $repository;

/**
* @var FormErrorSerializer
*/
private $formErrorSerializer;

public function __construct(
EntityManagerInterface $entityManager,
<?= $entity_name ?>Repository $repository,
FormErrorSerializer $formErrorSerializer
) {
$this->entityManager = $entityManager;
$this->repository = $repository;
$this->formErrorSerializer = $formErrorSerializer;
}

/**
* @Route("<?= $route_path; ?>",
* name="api_<?= $route_name; ?>_post",
* methods={"POST"}
* )
*
* @SWG\Post(
* consumes={"application/json"},
* produces={"application/json"},
* summary="Crée un nouvel <?= $entity_name ?>",
* @SWG\Response(
* response=201,
* description="Le <?= $entity_name ?> a bien été inséré.",
* @SWG\Schema(ref=@Model(type=<?= $entity_name ?>::class))
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
* name="Le <?= $entity_name ?> au format JSON.",
* in="body",
* required=true,
* @SWG\Schema(ref=@Model(type=<?= $entity_name ?>::class))
* )
* )
* @param Request $request
* @return View|JsonResponse
* @throws ExceptionInterface
*/
public function postAction(Request $request)
{
$data = $this->getDataFromJson($request, true);

//$responseChildren[] = $this->createOrUpdate($data, $this->);
$newEntity = new <?= $entity_name ?>();

$form = $this->createForm(<?= $entity_name ?>Type::class, $newEntity);
$form->submit($data, false);
$this->validationError(
$form,
$this
);
/*
$this->validationError(
$form,
$this,
$responseChildren
);
*/
$insertData = $form->getData();
//$this->manageDates($insertData);
$this->entityManager->persist($insertData);

$this->entityManager->flush();
return $this->view($insertData, Response::HTTP_CREATED);
}

/**
* @Route("<?= $route_path; ?>/{id}",
* name="api_<?= $route_name; ?>_get",
* methods={"GET"},
* requirements={
* "id": "\d+"
* })
*
* @SWG\Get(
* summary="Donne les informations de <?= $entity_name ?>.",
* produces={"application/json"}
* )
* @SWG\Response(
* response=200,
* description="Le <?= $entity_name ?> a bien été trouvé.",
* @SWG\Schema(ref=@Model(type=<?= $entity_name ?>::class))
* )
*
* @SWG\Response(
* response=404,
* description="Le <?= $entity_name ?> n'existe pas encore."
* )
* @param string $id
* @return View
*/
public function getAction(string $id)
{
return $this->view($this->getById($id));
}

/**
* @Route("<?= $route_path; ?>s",
* name="api_<?= $route_name; ?>_gets",
* methods={"GET"})
*
* @SWG\Get(
* summary="Retourne la liste de tout le <?= $entity_name ?>.",
* produces={"application/json"}
* )
* @SWG\Response(
* response=200,
* description="Retourne une JSON liste de tout le <?= $entity_name ?>.",
* @SWG\Schema(ref=@Model(type=<?= $entity_name ?>::class))
* )
*
* @QueryParam(name="page"
* , requirements="\d+"
* , default="1"
* , description="La page en cours.")
* @QueryParam(name="limit"
* , requirements="\d+"
* , default="0"
* , description="Le nombre de ligne du <?= $entity_name ?> à retourner dans la liste. 0 pour tous.")
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
* @Route("<?= $route_path; ?>/{id}",
* name="api_<?= $route_name; ?>_patch",
* methods={"PATCH"},
* requirements={
* "id": "\d+"
* })
*
* @SWG\Patch(
* summary="Mise à jour d'une partie de <?= $entity_name ?>. Les champs manquants ne sont pas modifiés.",
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
* name="JSON de <?= $entity_name ?>.",
* in="body",
* required=true,
* @SWG\Schema(ref=@Model(type=<?= $entity_name ?>::class)),
* description="Une partie de <?= $entity_name ?>."
* ),
* @SWG\Response(
* response=404,
* description="Le <?= $entity_name ?> n'a pas été trouvée."
* ),
* @SWG\Parameter(
* name="id",
* in="path",
* type="string",
* description="L'ID utilisé pour retrouver le <?= $entity_name ?>."
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
$form = $this->createForm(<?= $entity_name ?>::class, $existing);

$form->submit($data, $clearMissing);
$this->validationError($form, $this);
//$updateData = $form->getData();
//$this->manageDates($updateData);
$this->entityManager->flush();

return $this->view(null, Response::HTTP_NO_CONTENT);
}

/**
* @Route("<?= $route_path ?>/{id}",
* name="api_<?= $route_name ?>_delete",
* methods={"DELETE"},
* requirements={
* "id": "\d+"
* })
*
* @SWG\Delete(
* summary="Supprime le <?= $entity_name ?> de la base de données. Ne peut pas être annulé.",
* @SWG\Parameter(
* name="id",
* in="path",
* type="string",
* description="L'ID utilisé pour retrouver le <?= $entity_name ?>."
* )
* )
* @SWG\Response(
* response=204,
* description="Le <?= $entity_name ?> a bien été supprimée."
* )
*
* @SWG\Response(
* response=404,
* description="Le <?= $entity_name ?> n'existe pas."
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
* @return <?= $entity_name ?><?= "\n" ?>
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

private function manageDates(<?= $entity_name ?> $data, string $name)
{
switch ($name) {
case 'XXX':
$data->setXXX(new DateTime());
break;
default:
break;
}
}

}