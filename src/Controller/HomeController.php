<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookReadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private BookReadRepository $bookReadRepository;

    public function __construct(BookReadRepository $bookReadRepository)
    {
        $this->bookReadRepository = $bookReadRepository;
    }

    #[Route('/', name: 'app.home')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userId = 1;

        // Récupérer les livres lus par l'utilisateur
        $booksRead = $this->bookReadRepository->findByUserId($userId, false);

        // Créer le formulaire
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        // Traiter le formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();

            $this->addFlash('success', 'Livre ajouté avec succès.');
            return $this->redirectToRoute('app.home');
        }

        // Rendre la vue avec les livres lus et le formulaire
        return $this->render('pages/home.html.twig', [
            'booksRead' => $booksRead,
            'name' => 'Accueil',
            'addBookform' => $form->createView(),
        ]);
    }
}
