<?php

namespace App\Controller;

use App\Entity\Job;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class JobController extends Controller
{
    /**
     * @Route("/job", name="job")
     */
    public function index()
    {
        
        $jobs = $this->getDoctrine()->getRepository('App:Job')->findAll();
        $outputs = array_slice(array_reverse($jobs), 0, 3); 
        $total = count($jobs);
        return $this->render('job/index.html.twig',
            array ('jobs' => $jobs,
                    'total' => $total,
                    'outputs' => $outputs
                
            )
        );
    }

    /**
    * @Route("/job/create", name="job_create")
    */
    public function create(Request $request,UserInterface $user){
        
        $job = new Job();
        $userId = $user->getId();

        $form = $this->createFormBuilder($job)
            ->add('name',TextType::class, array('attr' => array('class'=> 'form-control','style' => 'margin-bottom:15px')))
            ->add('dateStart',DateType::class, array('label' => 'Data Inicio','attr' => array('class'=> 'formcontrol','style' => 'margin-bottom:15px')))
            ->add('dateEnd',DateType::class, array('label' => 'Data Fim','attr' => array('class'=> 'formcontrol','style' => 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label' => 'Criar Oportunidade','attr' => array('class' => 'btn btn-success')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$todo` variable has also been updated
            $job = $form->getData();
            $job->setUserId($userId);
    
            // ... perform some action, such as saving the todo to the database
            // for example, if Todo is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($job);
            $entityManager->flush();
    
            return $this->redirectToRoute('job');
        }

        return $this->render('job/create.html.twig', array('form' => $form->createView()));
    }

}
