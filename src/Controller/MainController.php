<?php

namespace App\Controller;

use App\Model\WeatherModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * Page d'accueil du site qui affiche la météo de toutes les villes
     * 
     * #[Route('/', name: 'app_main')] => on appelle ca une annotation sur symfony
     * et c'est ce qui permet de créer une route
     *
     * @return Response
     */
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        // 1ere etape : on récupère la meteo de toutes les villes via le model WeatherModel
        $datas = WeatherModel::getWeatherData();
        // dump($datas);
        // 2eme etape : on passe les données à la vue
        return $this->render('main/index.html.twig', [
            'datas' => $datas,
        ]);
    }

    /**
     * Page de détail d'une ville
     *
     * @return Response
     */
    #[Route('/show/{id}', name: 'app_show')]
    public function show($id)
    {
        // 1ere etape : je recupere les données de la ville voulue via son id
        $data = WeatherModel::getWeatherByCityIndex($id);
        dump($data);
        return $this->render('main/show.html.twig', [
            'data' => $data,
            // Je vais passer la valeur de $id à ma vue
            'index' => $id,
        ]);
    }

    /**
     * Ajoute les données de la ville choisie en session
     *
     * @param Request $request
     * @param int $id L'id de la ville qu'on veut afficher
     * @return void
     */
    #[Route('/city/select/{id}', name: 'app_city_select')]
    public function citySelect(Request $request, $id)
    {
        // 1ere etape : On recupere la session
        // doc : https://symfony.com/doc/current/session.html#basic-usage
        $session = $request->getSession();
        // 2eme etape : on recupere les données de la ville (sachant que l'id de la ville c'est $id)
        $data = WeatherModel::getWeatherByCityIndex($id);
        dump($data);
        // 3eme etape : on met les données de la ville en session
        // Dans la session on ajoute une clé sessionWeather et on lui associe les valeur de la ville selectionné, ici $data 
        $session->set('sessionWeather', $data);
        // 4eme etape : on redirige vers la page d'accueil
        return $this->redirectToRoute('app_main');
    }

    /**
     * Page montagnes
     *
     * @return Response
     */
    #[Route('/mountain', name: 'app_mountain')]
    public function mountain()
    {
        return $this->render('main/mountain.html.twig');
    }

    /**
     * Page plages
     *
     * @return Response
     */
    #[Route('/beach', name: 'app_beach')]
    public function beach()
    {
        return $this->render('main/beach.html.twig');
    }
}
