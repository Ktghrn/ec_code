<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\JsonResponse;



class BookController extends AbstractController
{
    public function createBookForm(Request $request, EntityManagerInterface $entityManager): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();

            // Réponse JSON pour une requête AJAX
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'book' => [
                        'id' => $book->getId(),
                        'name' => $book->getName(),
                        'description' => $book->getDescription(),
                        'rating' => $book->getRating(),
                        'completed' => $book->getCompleted(),
                    ],
                ]);
            }

            $this->addFlash('success', 'Le livre a été ajouté avec succès.');
            return $this->redirectToRoute('book_add');
        }

        // Si le formulaire est soumis mais invalide et c'est une requête AJAX
        if ($form->isSubmitted() && !$form->isValid() && $request->isXmlHttpRequest()) {
            return $this->json([
                'success' => false,
                'errors' => $this->getFormErrors($form),
            ], Response::HTTP_BAD_REQUEST);
        }

        // Retourner le formulaire sous forme de vue HTML
        return $this->render('modals/book.html.twig', [
            'addBookform' => $form->createView(),
        ]);
    }

    private function getFormErrors($form): array
    {
        $errors = [];
        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = (string)$form->get($child->getName())->getErrors();
            }
        }
        return $errors;
    }
}
