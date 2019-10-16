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


    public function __construct(
        EntityManagerInterface $entityManager, UsersWRepository $repository
    ) {
        $this->entityManager = $entityManager;
        $this->usersRepo = $repository;
    }

    /**
     * @Route("/", name="default")
     */
    public function index(Request $request)
    {
        $chatF= new UsersW();
        $form= $this->createForm(AddUserType::class,$chatF,[
                                                     'attr' => [
                                                         'method' => 'post',
                                                         'name' => 'addpost',
                                                         'id' => 'formaddpost',
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

        $chat = $this->usersRepo->findAll();
         return $this->render('/guestbook/index.html.twig', [
            'form' => $form->createView(),
            'appointments' => $chat,
             'error' => '',
        ]);
    }

    /**
     * @Route("addpost", name="add_post")
     */
    public function add_post(Request $request, Environment $environment)
      {     $dataGET = $request->query->get('add_user');
            $dataPOST = $request->request->get('add_user');
            $user = new UsersW();
            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
           if(isset($dataGET['firstName'])){
               $data= $dataGET;
           }
           elseif (isset($dataPOST['firstName']))
           {
               $data= $dataPOST;
           }
             $user->setFirstName(htmlspecialchars($data['firstName']));
             $user->setEmail(htmlspecialchars($data['email']));
             $user->sethomePage(htmlspecialchars($data['homePage']));
             $user->setMessage(htmlspecialchars($data['message']));
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
                  ]
              ]);
              $errstr=1;
              $error='User add message!';
              $form->add('save', SubmitType::class, ['label' => 'Add']);
              try {
                  $response->setContent(json_encode([
                      'html' => $environment->render('/guestbook/_form.html.twig', [
                          'form' => $form->createView(),
                          'error' => $error,
                      ]),
                      'errst' => $errstr]));
              } catch (LoaderError $e) {
              } catch (RuntimeError $e) {
              } catch (SyntaxError $e) {
              }

          }
          else{
              $error='User register our system';
              $errstr=0;

              $response->setContent(json_encode([
                  'errst' => $errstr,
                  'error' => $error
              ]));

          }
//        $person = $this->usersRepo->findAll(array('dateAdd' => 'DESC'));
//        $jsonContent = $serializer->serialize($person, 'json');

          return $response;

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


