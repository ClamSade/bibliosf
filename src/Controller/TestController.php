<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /* 
    Depuis PHP 8, certains commentaires qui commencent par #[ sont appelés des attributs. Cela petmet de passer des méta-données (= des informations supplémentaires) aux méthodes ou aux classes qui suivent l'attribut.

    Pour Symfony, l'attribut Route permet d'ajouter une route au projet. 
    Il s'agit du constructeur de la classe Route.

    1er paramètre : le chemin de la route (URL relative)
    Ensuite les paramètres sont nommés, par exemple 'name' permet de donner un nom à la route. Ce nom sera utilisé pour les redirections ou pour créer des liens HTML.

    Toutes les méthodes d'un contrôleur qui sont liées à une route doivent retourner un objet de la classe Response.
    */
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        /*
        La méthode render génère l'affichage de la page. Elle prend 2 arguments :
        1- le fichier template qui va être utilisé pour générer la page
        2- (optionnel) un array qui va contenir toutes les variables dont on aura besoin pour le template
        */
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    #[Route('/nouvelle-route')]
    public function nouvelle(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }


    /* 
    Lorsqu'on ajoute de {} dans le chemin d'une route, on crée une route paramétrée.
    Ce paramètre peut être remplacé par n'importe quelle valeur.
    On peut récupérer cette valeur dans une variable en définissant un argument ayant le même nom dans la méthode du contrôleur
    */
    #[Route('/salut/{prenom}', name: "salut")]
    public function salut($prenom): Response
    {
        return $this->render('test/salut.html.twig', [
            'prenom' => $prenom
        ]);
    }

    /*
    Si on ajoute un ? après le nom d'un paramètre dans les {} le paramètre devient optionnel, c'est à dire que la route correspond qu'il y ait ce paramètre ou non.

    L'argument 'requirements' permet de définir une expression régulière à laquelle le paramètre doit correspondre. Si ce n'est pas le cas, la route sera considéré comme inexistante.
    */

    #[Route('/test/calcul/{a?}/{b?}', name: "calcul", requirements: ['a' => '\d+', 'b' => '\d+'])]
    public function calcul($a, $b): Response
    {
        $a = !empty($a) ? $a : 0;
        $b = !empty($b) ? $b : 0;

        return $this->render('test/calcul.html.twig', [
            'a' => $a,
            'b' => $b
        ]);
    }

    #[Route('/test/tableau', name: "app_test_tableau")]
    public function tableau(): Response
    {
        $tableau = [ 4, "Ceci est du texte", true, "Encore du  texte"];

        return $this->render('test/tableau.html.twig', [
            "variable" => $tableau
        ]);
    }

    #[Route('/test/tableau-associatif', name: "app_test_tableau_associatif")]
    public function Associatif(): Response
    {
        $personne = [ "prenom" => "Jean", "nom" => "Aymar"];

        return $this->render('test/variable.html.twig', [
            "variable" => $personne
        ]);
    }
    
    #[Route('/test/objet', name: "app_test_objet")]
    public function objet(): Response
    {
        $personne = new stdClass;
        $personne -> nom = "Onyme";
        $personne -> prenom = "Anne";

        return $this->render('test/variable.html.twig', [
            "variable" => $personne
        ]);
    }
    
    // Pour restreaindre l'accès de certainesroutes, on peut utiliser les annotations (ou attributs) avec la classe IsGranted. Seuls les utilisateurs connectés ayant passé en argument pourront accéder à cette route. Sinon, ils seront redirigés vers une page erreur 403.

    #[Route('/test/admin', name: "app_test_admin")]
    #[IsGranted('ROLE_ADMIN')]
    public function testAdmin()
    {
        return $this->render('test/index.html.twig', [
            'controller_name'   =>  'cette page n\'est accessible qu\'aux Administrateur'
        ]);
    }

}
