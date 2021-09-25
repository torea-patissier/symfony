<?php

namespace App\Controller;
//Import de l'entité User
use \App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
         private $entityManager;
    
         public function __construct(EntityManagerInterface $entityManager)
         {
             $this->entityManager = $entityManager;
         }
    /**
     * @Route("/inscription", name="register")
     */

    public function index(Request $request, UserPasswordHasherInterface $encoder)
    /* Assigner l'objet symfony Request à une $ et idem pour UserPasswordHasherInterface 
    Quand j'instancie la fonction*/

    /* J'appelle Request et User.. quand j'exécute la foncion => INJECTION DE DEPENDANCE */


    {

        $user = new User();
        // J'instancie la classe

        $form = $this->createForm(RegisterType::class,$user);
        /* J'instancie le formulaire
        RegisterType == La classe du formulaire
        $user == Les datas de l'objet*/

        $form->handleRequest($request);
        //Permet de traiter la requête

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            //Injecter dans User toute les données du formulaire

            $password = $encoder->hashPassword($user,$user->getPassword());
            /* Permet de hasher le MDP AVANT l'envoi en BDD, prend en param les infos user
            ET le MDP récupéré avec get */

            $user->setPassword($password);
            /* Permet d'envoyer le MDP hashé en BDD */
            
            $this->entityManager->persist($user);
            // permet de figer la data entré pour l'enregistrer après
            $this->entityManager->flush();
        }

        //Je passe $form en variable au template
        return $this->render('register/index.html.twig',[
            'form' => $form->createView()
        ]);
        //'form' == moi qui choisit comment l'appeler
    }
}
