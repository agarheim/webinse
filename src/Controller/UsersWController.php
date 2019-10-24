<?php

namespace App\Controller;

use App\Entity\UsersW;
use App\Form\AddUserType;
use App\Form\UserImageType;
use App\Repository\UsersWRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class UsersWController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UsersWRepository
     */
    private $usersRepo;

    /**
     * @var Environment
     */
    private $env;

    public function __construct(
        EntityManagerInterface $entityManager, UsersWRepository $repository, Environment $environment
    )
    {
        $this->entityManager = $entityManager;
        $this->usersRepo = $repository;
        $this->env = $environment;
    }

    /**
     * @Route("/", name="default")
     */
    public function index(Request $request)
    {
        $chatF = new UsersW();
        $form = $this->buildForm($chatF);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $chatF->setDateAdd(new \DateTime('now'));
            if (!$this->usersRepo->addNewField($chatF->getEmail())) {
                $this->entityManager->persist($chatF);
                $this->entityManager->flush();
                return $this->redirectToRoute('default');
            }
        }
        return $this->render('/guestbook/index.html.twig', [
            'form' => $form->createView(),
            'appointments' => $this->allUser(),
            'error' => '',
        ]);
    }

    /**
     * @Route("addpost", name="add_post")
     */
    public function add_post(Request $request, Environment $environment)
    {
        $user = new UsersW();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $form = $this->buildForm($user);
        $form->handleRequest($request);
        $user->setDateAdd(new \DateTime('now'));
       if (!$this->usersRepo->addNewField($user->getEmail())) {

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $chatF = new UsersW();
            $form = $this->buildForm($chatF);
           $errstr = 1;
           $error = 'User add message!';
       }
           if($errstr===1) {
                $response->setContent(json_encode([
                    'html' => $this->env->render('/guestbook/_form.html.twig', [
                        'form' => $form->createView(),
                        'error' => $error,
                    ]),
                    'tables' =>  $this->allUser(),
                    'errst' => $errstr
                    ]
                ));

            }  else {
            $error = 'User register our system';
            $errstr = 0;

            $response->setContent(json_encode([
                'errst' => $errstr,
                'error' => $error
            ]));

        }
        return $response;
    }

    /**
     * @Route("alluser", name="all_user")
     */
    public function allUser()
    {
        try {
            return $this->env->render('/guestbook/_tableguest.html.twig', [
                'appointments' => $this->usersRepo->findAll(),]);
        } catch (LoaderError $e) {
        } catch (RuntimeError $e) {
        } catch (SyntaxError $e) {
        }
    }

    public function buildForm(UsersW $usersW)
    {
        $form = $this->createForm(AddUserType::class, $usersW, [
            'attr' => [
                'name' => 'addpost',
                'id' => 'formaddpost',
            ]
        ]);
        $form->add('save', SubmitType::class, ['label' => 'Add']);
        return $form;
    }
    /**
     * @Route("delete/{id}", name="user_delete")
     */
    public function userDelete(UsersW $usersW)
    {
        $this->entityManager->remove($usersW);
        $this->entityManager->flush();

        return $this->redirectToRoute('default');
    }

    /**
     * @Route("edit/{id}", name="user_edit")
     */
    public function userEdit(UsersW $usersW, UsersWRepository $repository, Request $request)
    {
        $form1 = $this->buildForm($usersW);
        $form1->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()) {
            if ($usersW->getEmail()) {
                $this->entityManager->persist($usersW);
                $this->entityManager->flush();
                return $this->redirectToRoute('default');
            } else {
                return $this->redirectToRoute('default');
            }
        }
        return $this->render('/guestbook/edituser.html.twig', [
            'form1' => $form1->createView(),
        ]);

    }
}


