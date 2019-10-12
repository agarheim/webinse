<?php
namespace App\Controller;

use App\Entity\UsersW;
use App\Form\AddUserType;
use App\Repository\UsersWRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


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
        $chat = $repository->findAll();
        // Paginate the results of the query
        $appointments = $paginator->paginate(
        // Doctrine Query, not results
            $chat,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );

        return $this->render('/guestbook/index.html.twig', [
            'form' => $form->createView(),
            'appointments' => $appointments,
        ]);
    }

    /**
     * @Route("submitpost", name="submit_post")
     */
    public function ajax_post($request, $chatF ){
       // $form_data = $request->get('task');

       //eturn new JsonResponse($form_data);
    }
      public function add_post( $chatF, $repository, $entityManager)
      {
          if(!$repository->addNewField($chatF->getEmail())) {
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


