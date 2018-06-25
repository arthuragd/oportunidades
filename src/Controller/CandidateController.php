<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Candidate;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CandidateController extends Controller
{
    /**
     * @Route("/candidate/view", name="candidate_view")
     */
    public function view()
    {
        return $this->render('candidate/view.html.twig');
    }

    /**
    * @Route("/candidate/create", name="candidate_create")
    */
    public function create(Request $request,UserInterface $user){
        
        $candidate = new Candidate();
        $userId = $user->getId();

        $curriculo = $this->getDoctrine()
                    ->getRepository('App:Candidate')->findOneBy(['user_id' => $userId]);
        if(!$curriculo){
            $form = $this->createFormBuilder($candidate)
                ->add('name',TextType::class, array('label' => 'Nome','attr' => array('class'=> 'form-control','style' => 'margin-bottom:15px')))
                ->add('cpf',TextType::class, array('label' => 'CPF','attr' => array('class'=> 'form-control','style' => 'margin-bottom:15px')))
                ->add('phone',TextType::class, array('label' => 'Telefone','attr' => array('class'=> 'form-control','style' => 'margin-bottom:15px')))
                ->add('ability',TextareaType::class, array('label' => 'Habilidades','attr' => array('class'=> 'form-control','style' => 'margin-bottom:15px')))
                ->add('link',TextareaType::class, array('label' => 'Link','attr' => array('class'=> 'form-control','style' => 'margin-bottom:15px')))
                ->add('experience',TextareaType::class, array('label' => 'Experiencia','attr' => array('class'=> 'form-control','style' => 'margin-bottom:15px')))
                ->add('save', SubmitType::class, array('label' => 'Adicionar Curriculo','attr' => array('class' => 'btn btn-success')))
                ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // $form->getData() holds the submitted values
                // but, the original `$todo` variable has also been updated
                $candidate = $form->getData();
                $candidate->setUserId($userId);
    
                // ... perform some action, such as saving the todo to the database
                // for example, if Todo is a Doctrine entity, save it!
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($candidate);
                $entityManager->flush();
                return $this->redirectToRoute('welcome');
            }
            return $this->render('candidate/create.html.twig', array('form' => $form->createView()));
        }
        return $this->forward('App\Controller\CandidateController::edit', array(
            'mensagem' => 'Voce Ja Possui Curriculo que tal Atualizar?'
        ));
    }

    /**
    * @Route("/candidate/edit", name="edit")
    */
    public function edit(Request $request, UserInterface $user, $mensagem){
       
        $m = $mensagem; 
        $userId = $user->getId();

        $candidate = $this->getDoctrine()
                    ->getRepository('App:Candidate')->findOneBy(['user_id' => $userId]);

                $form = $this->createFormBuilder($candidate)
                    ->add('name',TextType::class, array('label' => 'Nome','attr' => array('class'=> 'form-control','style' => 'margin-bottom:15px')))
                    ->add('cpf',TextType::class, array('label' => 'CPF','attr' => array('class'=> 'form-control','style' => 'margin-bottom:15px')))
                    ->add('phone',TextType::class, array('label' => 'Telefone','attr' => array('class'=> 'form-control','style' => 'margin-bottom:15px')))
                    ->add('ability',TextareaType::class, array('label' => 'Habilidades','attr' => array('class'=> 'form-control','style' => 'margin-bottom:15px')))
                    ->add('link',TextareaType::class, array('label' => 'Link','attr' => array('class'=> 'form-control','style' => 'margin-bottom:15px')))
                    ->add('experience',TextareaType::class, array('label' => 'Experiencia','attr' => array('class'=> 'form-control','style' => 'margin-bottom:15px')))
                    ->add('save', SubmitType::class, array('label' => 'Salvar Curriculo','attr' => array('class' => 'btn btn-success')))
                    ->getForm();

                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    // $form->getData() holds the submitted values
                    // but, the original `$todo` variable has also been updated
                    $candidate = $form->getData();
                    $candidate->setUserId($userId);
        
                    // ... perform some action, such as saving the todo to the database
                    // for example, if Todo is a Doctrine entity, save it!
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($candidate);
                    $entityManager->flush();
                    return $this->redirectToRoute('welcome');
                }
        return $this->render('candidate/edit.html.twig', array(
            'candidate' => $candidate,
            'm' => $m,
            'form' => $form->createView()
        ));
    }

}