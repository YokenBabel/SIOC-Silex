<?php

namespace SIOC\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of UtilisateurController
 *
 * @author leetspeakv2
 */
class UtilisateurController {
    
    /**
     * Affichage Utilisateurs
     * 
     * @param Application $app Silex Application
     */
    public function utilisateurAction(Application $app)
    {
        $utilisateurs = $app['dao.utilisateur']->findAll();
        return $app['twig']->render('utilisateur.html.twig', array('utilisateurs' => $utilisateurs));
    }
    
    /**
     * Affichage des professeurs
     * 
     * @param Application $app Silex Application
     */
    public function professeurAction(Application $app)
    {
        $professeurs = $app['dao.utilisateur']->findAllProfesseur();
        return $app['twig']->render('professeurs.html.twig', array('professeurs' => $professeurs));
    }
    
    /**
     * Formulaire ajout Utilisateur
     * 
     * @param Application $app Silex Application
     */
    public function utilisateurAjoutAction(Application $app)
    {
        $promotions = $app['dao.promotion']->findAll();
        return $app['twig']->render('ajout_utilisateur.html.twig', array('promotions' => $promotions));
    }
    
    /**
     * Insertion Utilisateur
     * 
     * @param Application $app Silex Application
     * @param Request $request Requete Entrante
     */
    public function utilisateurInsertAction(Application $app, Request $request)
    {
        $salt = substr(md5(time()), 0, 23);
        $utilisateur = new \SIOC\donnees\Utilisateur();
        $promotion = new \SIOC\donnees\Promotion();
        $utilisateur->setUsername($request->request->get('username'));
        $utilisateur->setNom($request->request->get('nom'));
        $utilisateur->setPrenom($request->request->get('prenom'));
        $utilisateur->setMail($request->request->get('email'));
        $utilisateur->setSalt($salt);
        $encoder = $app['security.encoder.digest'];
        $utilisateur->setPassword($encoder->encodePassword($request->request->get('password'),$utilisateur->getSalt()));
        $utilisateur->setRole($request->request->get('role'));
        if($utilisateur->getRole() == 'ROLE_ELEVE'){
            $promotion->setId($request->request->get('promo'));
        }
        $app['dao.utilisateur']->save($utilisateur, $promotion);
        $utilisateurs = $app['dao.utilisateur']->findAll();
        return $app['twig'] -> render('utilisateur.html.twig', array('utilisateurs' => $utilisateurs));
    }
    
    /**
     * Suppression Utilisateur
     * 
     * @param integer $id Id utilisateur
     * @param Application $app Silex Application
     */
    public function utilisateurSupAction($id, Application $app)
    {
        // TODO
    }
    
    /**
     * Edition Utilisateur
     * 
     * @param integer $id Id utilisateur
     * @param Application $app Silex Application
     */
    public function utilisateurEditAction($id, Application $app)
    {
        // TODO
    }
}
