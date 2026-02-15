<?php

namespace App\Controller\Front;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Signalement;
use App\Form\CommentType;
use App\Form\SignalementType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PostController extends AbstractController
{
    #[Route('/', name: 'front_home')]
    public function home(PostRepository $postRepository): Response
    {
        return $this->render('front/home.html.twig', [
            'latestPosts' => $postRepository->findBy([], ['id' => 'DESC'], 3),

        ]);
    }

    #[Route('/actualites', name: 'front_posts')]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findBy([], ['id' => 'DESC']);


        return $this->render('front/posts/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/actualites/{id}', name: 'front_post_show', requirements: ['id' => '\d+'])]
    public function show(Post $post, Request $request, EntityManagerInterface $em): Response
    {
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            if (!$this->getUser()) {
                $this->addFlash('error', 'Vous devez être connecté pour commenter.');
                return $this->redirectToRoute('app_login');
            }

            $comment->setUser($this->getUser());
            $comment->setPost($post);
            $comment->setCreatedAt(new \DateTimeImmutable());
            $comment->setUpdatedAt(new \DateTimeImmutable());

            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', 'Commentaire ajouté.');
            return $this->redirectToRoute('front_post_show', ['id' => $post->getId()]);
        }

        return $this->render('front/posts/show.html.twig', [
            'post' => $post,
            'commentForm' => $commentForm->createView(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/commentaires/{id}/signaler', name: 'front_comment_signal', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function signal(Comment $comment, Request $request, EntityManagerInterface $em): Response
    {
        $signalement = new Signalement();
        $form = $this->createForm(SignalementType::class, $signalement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $signalement->setComment($comment);
            $signalement->setCreatedAt(new \DateTimeImmutable());
            $signalement->setUpdatedAt(new \DateTimeImmutable());

            $em->persist($signalement);
            $em->flush();

            $this->addFlash('success', 'Merci, le commentaire a été signalé.');
            return $this->redirectToRoute('front_post_show', [
                'id' => $comment->getPost()->getId(),
            ]);
        }

        return $this->render('front/comments/signal.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }
}
