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

class UsersWController extends AbstractController
{
    /**
     * @Route("/", name="default")
     * @param UsersWRepository $repository
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */
    public function index(UsersWRepository $repository, Request $request, EntityManagerInterface $entityManager)
    {
        $chatF= new UsersW();

        $form11= $this->createForm(AddUserType::class,$chatF);
        $form11->add('save', SubmitType::class, ['label' => 'Add']);
        $form11->handleRequest($request);

        if ($form11->isSubmitted() && $form11->isValid()) {
            if(!$repository->addNewField($chatF->getEmail())) {
                $this->addFlash(
                    'notice',
                    'Your changes were saved!'
                );
                $entityManager->persist($chatF);
                $entityManager->flush();
                return $this->redirectToRoute('default');
            }

        }
        $chat = $repository->findAll();
        return $this->render('/guestbook/index.html.twig', [
            'chat' => $chat,
            'form11' => $form11->createView(),
            'error' => '',
        ]);
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


