<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherController extends AbstractController
{
    private $client;

    /**
     * @param $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/weather', name: 'app_weather')]
    public function index(Request $request): Response
    {
        $city = $request->request->get('City');
        $response = $this->client->request('GET',
            'http://api.weatherapi.com/v1/forecast.json?key=c4d1046851bb44efa42214419222310&q=' . $city . ' &days=5&aqi=yes&alerts=no');
        $content = $response->getContent();
        $data = json_decode($content);
        $location = $data->location;
        $current = $data->current;
        $days = $data->forecast->forecastday;


        return $this->render('weather/index.html.twig', [
            'days' => $days,
            'current' => $current,
            'location' => $location
        ]);
    }


    #[Route('/weather1', name: 'app_weather1')]
    public function index2(Request $request): Response
    {
        $city = $request->request->get('City');
        $response = $this->client->request('GET',
            'http://api.weatherapi.com/v1/forecast.json?key=c4d1046851bb44efa42214419222310&q=' . $city . ' &days=5&aqi=yes&alerts=no');
        $content = $response->getContent();
        $data = json_decode($content);

        $location = $data->location;
        $current = $data->current;
        $days = $data->forecast->forecastday;


        return $this->render('weather/index2.html.twig', [
            'days' => $days,
            'current' => $current,
            'location' => $location
        ]);
    }
    #[Route('/', name: 'Home')]
    public function Home(): Response
    {
        return $this->render('weather/Home.html.twig', []);
    }
}