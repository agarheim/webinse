<?php
namespace App\Controller;

use App\Entity\UsersW;
use App\Form\AddUserType;
use App\Repository\UsersWRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


class UsersWController extends AbstractController
{
    /**
     * @Route("/", name="default")
     * @param UsersWRepository $repository
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */
    public function index(UsersWRepository $repository, Request $request,
                          EntityManagerInterface $entityManager, PaginatorInterface $paginator)
    {
        $chatF= new UsersW();

        $form= $this->createForm(AddUserType::class,$chatF,[
                                                     'attr' => [
                                                         'method' => 'POST',
                                                         'name' => 'addpost',
                                                         'action' => ''
                                                     ]
        ]);
        $form->add('save', SubmitType::class, ['label' => 'Add']);
        $form-> handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
           {   $this->add_post( $chatF, $repository, $entityManager);
               return $this->redirectToRoute('default');
           }
//        if($request->isXmlHttpRequest())
//        {
//            echo 'asdfasdfasdfsadfasdf';
//        }
//        else
//        {echo 'фигушки';}

        $chat = $repository->findAll();
         return $this->render('/guestbook/index.html.twig', [
            'form' => $form->createView(),
            'appointments' => $chat,
        ]);
    }
      public function add_post( $chatF, $repository, $entityManager)
      {
          if(!$repository->addNewField($chatF->getEmail())) {
                  $chatF->setDateAdd (new \DateTime('now'));
                  $entityManager->persist($chatF);
                  $entityManager->flush();
           }

      }
    /**
     * @Route("delete/{id}", name="user_delete")
     */
    public function userDelete(UsersW $usersW, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($usersW);
        $entityManager->flush();

        return $this->redirectToRoute('default');
    }

    /**
     * @Route("edit/{id}", name="user_edit")
     */
    public function userEdit(UsersW $usersW, UsersWRepository $repository, Request $request, EntityManagerInterface $entityManager)
    {
        $form1 = $this->createFormBuilder( $usersW)

            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();
        $form1->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()) {
            if($repository->addNewField($usersW->getEmail())) {
                $entityManager->persist($usersW);
                $entityManager->flush();
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


