<?php
// src/Controller/RegistrationController.php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Job;
use App\Entity\Register;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user_registration")
     */
    public function index(UserInterface $user)
    {
        
        $userName = $user->getUsername();
        $user_id = $user->getId();

        $jobs = $this->getDoctrine()->getRepository('App:Register')->findBy(['user_id' => $user_id]);
        

        if(in_array('ROLE_USER', $this->getUser()->getRoles())){
            return $this->render('user/indexAdm.html.twig',array(
                'userName' => $userName
            ));       
         }
        if(in_array('ROLE_CANDIDATE', $this->getUser()->getRoles())){
            return $this->render('user/indexCandidate.html.twig',array(
                'userName' => $userName,
                'jobs' => $jobs
            )); 
        }
    }
}
