<?php
namespace App\Controller;

use App\Entity\Movie;
use App\Entity\OrderFilter;
use App\Form\Type\MovieType;
use App\Form\Type\EditMovieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use DateTime;

class MovieController extends AbstractController {

    public function accueil() {
        return $this->render('movie/accueil.html.twig');
    }

    public function createMovie(Request $request) {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie, ['action' => $this->generateUrl('createMovie')]);
        $form->add('submit', SubmitType::class, array('label' => 'Save'));
        $form->handleRequest($request);
        if ($form->isSubmitted()  && $form->isValid()) {
            $file = $form->get('cover')->getData();
            if ($file) {
                $filename = "/cover/".trim($movie->getTitle()).'.'.'png';
                $file->move($this->getParameter('upload_directory'), $filename);
            }else{
                $filename = "/cover/empty.png";
            }
            $movie->setCover($filename);
            $movie->setUser($this->getUser());
            $movie->setVue(0);
            $movie->setCreateDate(new DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($movie);
            $entityManager->flush();
            return $this->redirectToRoute('movies');
        }
        return $this->render('movie/addMovie.html.twig',
            array('monFormulaire' => $form->createView()));
    }

    public function showMovies() {
        $OrderFilter = $this->getDoctrine()->getRepository(OrderFilter::class)->findByUser($this->getUser());
        $filter = $OrderFilter[0]->getFiltre();
        $order = $OrderFilter[0]->getOrdre();
        $affichage = $OrderFilter[0]->getAffichage();
        $asc = $OrderFilter[0]->getAscen();

        if ($filter == "seen") {
            $movies = $this->getDoctrine()->getRepository(Movie::class)->findByVue($this->getUser(), 1, $order, $asc);
        }else{
            if ($filter == "notseen") {
                $movies = $this->getDoctrine()->getRepository(Movie::class)->findByVue($this->getUser(), 0, $order, $asc);
            }else{
                $movies = $this->getDoctrine()->getRepository(Movie::class)->findByUser($this->getUser(), $order, $asc);
            }
        }
        return $this->render('movie/movies.html.twig',
            array('movies' => $movies, 'filter' => $filter, 'affichage' => $affichage, 'asc' => $asc));
    }

    public function showMovie($id) {
        $movie = $this->getDoctrine()->getRepository(Movie::class)->find($id);
        if(!$movie)
            throw $this->createNotFoundException('Movie[id='.$id.'] inexistant');
        return $this->render('movie/movie.html.twig',
            array('movie' => $movie));
    }

    public function editMovie($id, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $movie = $entityManager->getRepository(Movie::class)->find($id);
        $cover = $movie->getCover();
        if (!$movie) {
            throw $this->createNotFoundException('Movie[id='.$id.'] inexistant');
        }
        $form = $this->createForm(MovieType::class, $movie, ['action' => $this->generateUrl('editMovie', array('id' => $id))]);
        $form->add('submit', SubmitType::class, array('label' => 'Edit'));
        $form->handleRequest($request);
        if ($form->isSubmitted()  && $form->isValid()) {
            $file = $form->get('cover')->getData();
            if ($file) {
                if ($cover != "/cover/empty.png") {
                    $cover = str_replace("cover/", "", $cover);
                    $oldfile = $this->getParameter('upload_directory').$cover;
                    unlink($oldfile);
                }
                $filename = "/cover/".trim($movie->getTitle()).'.'.'png';
                $file->move($this->getParameter('upload_directory'), $filename);
                $movie->setCover($filename);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('movie',
                array('id' => $movie->getId()));
        }
        return $this->render('movie/editMovie.html.twig',
            array('monFormulaire' => $form->createView()));
    }

    public function removeMovie($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $movie = $this->getDoctrine()->getRepository(Movie::class)->find($id);
        if (!$movie) {
            throw $this->createNotFoundException('Movie[id=' . $id . '] inexistant');
        } else {
            if ($movie->getCover() != "/cover/empty.png") {
                $cover = str_replace("cover/", "", $movie->getCover());
                $oldfile = $this->getParameter('upload_directory').$cover;
                unlink($oldfile);
            }
            $entityManager->remove($movie);
            $entityManager->flush();
            $movies = $this->getDoctrine()->getRepository(Movie::class)->findAll();
            return $this->render('movie/movies.html.twig',
                array('movies' => $movies));
        }
    }

    public function vueMovie($id, $page, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $movie = $entityManager->getRepository(Movie::class)->find($id);
        if (!$movie) {
            throw $this->createNotFoundException('Movie[id='.$id.'] inexistant');
        }
        $movie->setVue(1);
        $movie->setVueDate(new DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        if ($page == 'movie')
            return $this->redirectToRoute('movie', array('id' => $id));
        else
            return $this->redirectToRoute('movies');
    }

    public function pasvueMovie($id, $page, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $movie = $entityManager->getRepository(Movie::class)->find($id);
        if (!$movie) {
            throw $this->createNotFoundException('Movie[id='.$id.'] inexistant');
        }
        $movie->setVue(0);
        $movie->setVueDate(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        if ($page == 'movie')
            return $this->redirectToRoute('movie', array('id' => $id));
        else
            return $this->redirectToRoute('movies');
    }

    public function saveFilter($filter) {
        $entityManager = $this->getDoctrine()->getManager();
        $of = $entityManager->getRepository(OrderFilter::class)->findByUser($this->getUser());

        $of[0]->setFiltre($filter);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('movies');
    }

    public function saveOrder($order, $asc) {
        $entityManager = $this->getDoctrine()->getManager();
        $of = $entityManager->getRepository(OrderFilter::class)->findByUser($this->getUser());

        $of[0]->setOrdre($order);
        $of[0]->setAscen($asc);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('movies');
    }

    public function saveAffichage($affichage) {
        $entityManager = $this->getDoctrine()->getManager();
        $of = $entityManager->getRepository(OrderFilter::class)->findByUser($this->getUser());

        $of[0]->setAffichage($affichage);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('movies');

    }
}
