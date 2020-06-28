<?php

namespace App\Controller;

use App\Entity\OrderFilter;
use App\Entity\User;
use App\Entity\Movie;
use App\Form\EditUserType;
use App\Form\Type\UserType;
use App\Form\UserImgType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController {

    public function user() {
        $user = $this->getUser();
        return $this->render('user/user.html.twig',
            array('user' => $user));
    }

    public function addUser(Request $request, UserPasswordEncoderInterface $encoder) {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['action' => $this->generateUrl('addUser')]);
        $form->add('submit', SubmitType::class, array('label' => 'Save'));
        $form->handleRequest($request);
        if ($form->isSubmitted()  && $form->isValid()) {
            $file = $form->get('profil_img')->getData();
            if ($file) {
                $filename = "/image/".trim($user->getUsername()).'.'.'png';
            }else{
                $filename = "/image/empty.png";
            }
            $file->move($this->getParameter('upload_directory_profil'), $filename);
            $user->setProfilImg($filename);
            $encrypted = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($encrypted);
            $user->setRoles(['ROLE_USER']);
            $user->setCreateDate(new \DateTime());
            $OrderFilter = new OrderFilter();
            $OrderFilter->setFiltre("notseen");
            $OrderFilter->setOrdre("alpha");
            $OrderFilter->setUser($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->persist($OrderFilter);
            $entityManager->flush();
            return $this->redirectToRoute('movies');
        }
        return $this->render('user/addUser.html.twig',
            array('monFormulaire' => $form->createView()));
    }

    public function editUserImg(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($this->getUser());
        $img = $user->getProfilImg();
        $form = $this->createForm(UserImgType::class, $user, ['action' => $this->generateUrl('editUserImg')]);
        $form->add('submit', SubmitType::class, array('label' => 'Save'));
        $form->handleRequest($request);
        if ($form->isSubmitted()  && $form->isValid()) {
            $file = $form->get('profil_img')->getData();
            if ($file) {
                if ($img != "/image/empty.png") {
                    $img = str_replace("image/", "", $img);
                    $oldfile = $this->getParameter('upload_directory_profil').$img;
                    unlink($oldfile);
                }
                $filename = "/image/".trim($user->getUsername()).'.'.'png';
                $file->move($this->getParameter('upload_directory_profil'), $filename);
                $user->setProfilImg($filename);
            }

            $entityManager->flush();
            return $this->redirectToRoute('movies');
        }
        return $this->render('user/editUserImg.html.twig',
            array('monFormulaire' => $form->createView()));
    }

    public function editUser(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($this->getUser());
        $form = $this->createForm(EditUserType::class, $user, ['action' => $this->generateUrl('editUser')]);
        $form->add('submit', SubmitType::class, array('label' => 'Save'));
        $form->handleRequest($request);
        if ($form->isSubmitted()  && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('user');
        }
        return $this->render('user/editUser.html.twig',
            array('monFormulaire' => $form->createView()));
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout() { }


}