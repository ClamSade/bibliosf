<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\UpdateAuteurType;
use App\Repository\AuteurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuteurController extends AbstractController
{
    #[Route('/auteur', name: 'app_auteur')]
    public function index(AuteurRepository $auteurRepository): Response
    {
        $auteurs = $auteurRepository->findAll();

        return $this->render('auteur/index.html.twig', [
            'auteurs' => $auteurs
        ]);
    }

    /*
        Pour enregistrer en BDD, on va utiliser un objet Entité pour les valeurs.
        Pour exécuter les requêtes, on va devoir utiliser une classe Repository.
        C'est une classe qu'on ne peut utiliser qu'en passant par les arguments d'une méthode d'un contrôleur (comme la classe Request)
    */
    #[Route('/addAuteur', name: 'app_add_auteur')]
    public function addAuteur(Request $request, AuteurRepository $auteurRepository): Response
    {
        // dd($request); 
        /* la fonction dump est l'équivalent de var_dump pour symfony
             la fonction dd fait un dump puis die. 
             Cette objet a des propriétés de type objet qui contiennent toutes les valeurs des superglobales de PHP :
             $request->request      $_POST
             $request->query        $_GET 
             $request->files        $_FILEST
             ...                     ...
             
             Chacune de ces propriétés a des méthodes pour récupérer les valeurs :
             $request->request->get(inputname)      pour récupérer le valeur d'un input
             $request->request->has(name)           pour savoir si l'indice 'name' existe
             ...
         */ 
        if( $request->isMethod("POST"))
        {
            $nom = $request->request->get("nom");
            $prenom = $request->request->get("prenom");
            $biographie = $request->request->get("biographie");

            $auteur = new Auteur;
            $auteur->setNom($nom);
            $auteur->setPrenom($prenom);
            $auteur->setBiographie($biographie);
            
            $auteurRepository->save($auteur, true);
            $this->addFlash("success", "Le nouvel auteur a bien été enregistré !");

            return $this->redirectToRoute('app_auteur');
        }
        return $this->render('auteur/formulaire.html.twig');
    }

    #[Route('/updateAuteur/{id}', name: 'app_update_auteur', requirements: ["id" => "\d+"])]
    public function updateAuteur(AuteurRepository $ar, Request $rq, int $id)
    {
        $auteur = $ar->find($id);
        $form = $this->createForm(UpdateAuteurType::class, $auteur);
        /*
            La méthode handleRequest(prend 1 argument de la classe Request) va permettre à l'objet formulaire de gérer la requête HTTP : l'objet form va pouvoir gérer directement les données envoyées par le formulaire, plus besoin d'utiliser l'objet Request
        */
        $form->handleRequest($rq);
        if($form->isSubmitted() && $form->isValid())
        {
            $ar->save($auteur, true);
            $this->addFlash("success", "L'auteur n°$id a bien été modifié !");

            return $this->redirectToRoute('app_auteur');
        }

        return $this->render('auteur/form.html.twig', [
            'formAuteur' => $form->createView()
        ]);
    }

    #[Route('/deleteAuteur/{id}', name: 'app_delete_auteur', requirements: ["id" => "\d+"])]
    public function deleteAuteur(AuteurRepository $ar, Auteur $auteur, Request $rq)
    {
        if($rq->isMethod('POST'))
        {
            $this->addFlash("success", "L'auteur n°" . $auteur->getId() . " a bien été supprimé !");
            $ar->remove($auteur, true);

            return $this->redirectToRoute('app_auteur');
        }

       return $this->render('auteur/confirmation.html.twig', [ 
            'auteur' => $auteur 
        ]);
    }

}
