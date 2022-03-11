<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Form\UserType;
use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


        /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $requeteHttp,EntityManagerInterface $I,UserPasswordEncoderInterface $encoder): Response
    {   
        

        
        //créer un utilisateur 
        $user = new User();

        $formulaireUser= $this->createForm(UserType::class, $user);

        $formulaireUser->handleRequest($requeteHttp);
        
        if($formulaireUser->isSubmitted()&&$formulaireUser->isValid()){
            //attribuer un role a l'utilisateur
            $user->setRoles(["ROLE_USER"]);

            //encoder le mot de passe
            $encodageMDP = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($encodageMDP);

            $I->persist($user);
            $I->flush();
            return $this->redirectToRoute('app_login');

        }


    
        return $this->render('pro_stages/inscription.html.twig', [
            'formulaire'=>$formulaireUser->createView(),
        
        
        ]);


           
    }
}
