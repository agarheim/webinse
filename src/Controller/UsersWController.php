<?php
namespace App\Controller;

use App\Entity\UsersW;
use App\Form\AddUserType;
use App\Repository\UsersWRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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


    public function __construct(
        EntityManagerInterface $entityManager, UsersWRepository $repository
    ) {
        $this->entityManager = $entityManager;
        $this->usersRepo = $repository;
    }

    /**
     * @Route("/", name="default")
     * @param Request $request
     */
    public function index(Request $request)
    {
        $chatF= new UsersW();
        $form= $this->createForm(AddUserType::class,$chatF,[
                                                     'attr' => [
                                                         'method' => 'post',
                                                         'name' => 'addpost',
                                                         'id' => 'formaddpost',
                                                         'enctype'=> 'multipart/form-data',

                                                     ]
        ]);
        $form->add('save', SubmitType::class, ['label' => 'Add']);
        $form-> handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
           {
               $chatF->setDateAdd (new \DateTime('now'));
              if(!$chatF->getEmail()) {
                  $this->entityManager->persist($chatF);
                  $this->entityManager->flush();
                  return $this->redirectToRoute('default');
              }
           }

        $chat = $this->usersRepo->findAll(array('dateAdd' => 'DESC'));
         return $this->render('/guestbook/index.html.twig', [
            'form' => $form->createView(),
            'appointments' => $chat,
             'c' => '',
        ]);
    }

    /**
     * @Route("addpost", name="add_post")
     * @param Request $request
     * @return Response
     */
    public function add_post(Request $request)
      {
            $user = new UsersW();

             $user->setFirstName(htmlspecialchars($request->request->get('add_user')['firstName']));
             $user->setEmail(htmlspecialchars($request->request->get('add_user')['email']));
             $user->sethomePage(htmlspecialchars($request->request->get('add_user')['homePage']));
             $user->setMessage(htmlspecialchars($request->request->get('add_user')['message']));
             $user->setDateAdd(new \DateTime('now'));

          if(!$this->usersRepo->addNewField($user->getEmail())) {
                  $this->entityManager->persist($user);
                  $this->entityManager->flush();
              $chatF= new UsersW();
              $form= $this->createForm(AddUserType::class,$chatF,[
                  'attr' => [
                      'method' => 'post',
                      'name' => 'addpost',
                      'id' => 'formaddpost',
                      'enctype'=> 'multipart/form-data',

                  ]
              ]);
              $form->add('save', SubmitType::class, ['label' => 'Add']);
              return $this->render('/guestbook/_form.html.twig', [
                  'form' => $form->createView(),
                  'c' => 'User add message!'
              ]);
           }
          else{
              $error='User register our system';
          }
//        $person = $this->usersRepo->findAll(array('dateAdd' => 'DESC'));
//        $jsonContent = $serializer->serialize($person, 'json');
          return new Response($error);

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
        $form1 = $this->createFormBuilder( $usersW)

            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();
        $form1->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()) {
            if($usersW->getEmail()) {
                $this->entityManager->persist($usersW);
                $this->entityManager->flush();
                return $this->redirectToRoute('default');
            }
            else {
                return $this->redirectToRoute('default');
            }
        }
        return $this->render('/guestbook/edituser.html.twig', [
            'form1' => $form1->createView(),
        ]);

    }
}


