<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;

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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use DateTime;

/**
 * Class UserController
 * @package App\Controller
 *
 * Je spécifie que toute les entrées HTTP qui sont définies dans ce fichier auront comme préfix /api
 * ce qui donne une URL de ce genre: http://URL:PORT/api/XXX
 *
 * @Route("api")
 * @SWG\Tag(
 * name="UserController"
 * )
 *
 */
class UserController extends AbstractFOSRestController
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
     * @var UserRepository
     */
    private $repository;

    /**
     * @var FormErrorSerializer
     */
    private $formErrorSerializer;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $repository,
        FormErrorSerializer $formErrorSerializer,
        UserPasswordEncoderInterface $passwordEncoder

    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->formErrorSerializer = $formErrorSerializer;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Register an user to the DB.
     *
     * @Route("/auth/register", name="api_auth_register",  methods={"POST"})
     *
     * @SWG\Post(
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response(
     *      response=307,
     *      description="Redirect to login form with the user as parameter"
     *    ),
     *    @SWG\Response(
     *     response=500,
     *     description="The form is not correct<BR/>
     * See the corresponding JSON error to see which field is not correct"
     *    ),
     *    @SWG\Parameter(
     *     name="The JSON Characteristic",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *       ref=@Model(type=User::class)
     *     ),
     *     description="The JSon Characteristic"
     *    )
     * )
     *
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     * @throws ExceptionInterface
     * @throws ExceptionInterface
     */
    public function register(Request $request)
    {
        $data = json_decode(
            $request->getContent(),
            true
        );
        $form = $this->createForm(
            UserType::class,
            new User()
        );
        $form->submit($data, false);
        $validation = $this->validationError($form, $this);

        $user = $form->getData();
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $user->getPassword()
        ));

        $user->setRoles(['ROLE_USER']);
        $user->setCreated(new DateTime());
        $user->setLastLogin(new DateTime());
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        # Code 307 preserves the request method, while redirectToRoute() is a shortcut method.
        return $this->redirectToRoute('api_login_check', [
            'username' => $data['username'],
            'password' => $data['password']
        ], 307);
    }


    /**
     * @Route("/user/{username}",
     * name="api_user_get",
     * methods={"GET"})
     *
     * @SWG\Get(
     * summary="Donne les informations de User.",
     * produces={"application/json"}
     * )
     * @SWG\Response(
     * response=200,
     * description="Le User a bien été trouvé.",
     * @SWG\Schema(ref=@Model(type=User::class))
     * )
     *
     * @SWG\Response(
     * response=404,
     * description="Le User n'existe pas encore."
     * )
     * @param string $username
     * @return View
     */
    public function getAction(string $username)
    {
        return $this->view($this->findUserByName($username));
    }

    /**
     * @Route("/users",
     * name="api_user_gets",
     * methods={"GET"})
     *
     * @SWG\Get(
     * summary="Retourne la liste de tout le User.",
     * produces={"application/json"}
     * )
     * @SWG\Response(
     * response=200,
     * description="Retourne une JSON liste de tout le User.",
     * @SWG\Schema(ref=@Model(type=User::class))
     * )
     *
     * @QueryParam(name="page"
     * , requirements="\d+"
     * , default="1"
     * , description="La page en cours.")
     * @QueryParam(name="limit"
     * , requirements="\d+"
     * , default="0"
     * , description="Le nombre de ligne du User à retourner dans la liste. 0 pour tous.")
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
     * @Route("/user/{id}",
     * name="api_user_patch",
     * methods={"PATCH"},
     * requirements={
     * "id": "\d+"
     * })
     *
     * @SWG\Patch(
     * summary="Mise à jour d'une partie de User. Les champs manquants ne sont pas modifiés.",
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
     * name="JSON de User.",
     * in="body",
     * required=true,
     * @SWG\Schema(ref=@Model(type=User::class)),
     * description="Une partie de User."
     * ),
     * @SWG\Response(
     * response=404,
     * description="Le User n'a pas été trouvée."
     * ),
     * @SWG\Parameter(
     * name="id",
     * in="path",
     * type="string",
     * description="L'ID utilisé pour retrouver le User."
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
        $form = $this->createForm(User::class, $existing);

        $form->submit($data, $clearMissing);
        $this->validationError($form, $this);
        //$updateData = $form->getData();
        //$this->manageDates($updateData);
        $this->entityManager->flush();

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/user/{id}",
     * name="api_user_delete",
     * methods={"DELETE"},
     * requirements={
     * "id": "\d+"
     * })
     *
     * @SWG\Delete(
     * summary="Supprime le User de la base de données. Ne peut pas être annulé.",
     * @SWG\Parameter(
     * name="id",
     * in="path",
     * type="string",
     * description="L'ID utilisé pour retrouver le User."
     * )
     * )
     * @SWG\Response(
     * response=204,
     * description="Le User a bien été supprimée."
     * )
     *
     * @SWG\Response(
     * response=404,
     * description="Le User n'existe pas."
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
     * @return User
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
     * @param string $username can be id, username or email.
     *
     * @return User
     * @throws NotFoundHttpException
     */
    private function findUserByName(string $username)
    {
        $existingUser = $this->repository->findUserByUsernameOrEmail($username);
        if (null === $existingUser)
            throw new NotFoundHttpException();
        return $existingUser;
    }
}
