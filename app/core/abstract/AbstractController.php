<?php

namespace App\Core\Abstract;
use App\Core\App;
use App\Core\Session;
use App\Core\ImageService;

abstract class AbstractController extends Session{
 

    protected   $layout = 'base';

    protected $session;
    
    private static AbstractController|null $instance = null;

    public static function getInstance(){
        if(self::$instance === null){
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function __construct(){
        $this->session = App::getDependency('session');
    }


    abstract public function index();
    abstract public function create();
    abstract public function store();
    abstract public function edit();
    // abstract public function destroy();
    abstract public function show();

    

    // public function renderJson($data){
    //     header('Content-Type: application/json');
    //     echo json_encode($data);
    // }
    
      public function renderJson($data, $httpCode = 200)
    {
        // Nettoyer tout buffer de sortie précédent
        if (ob_get_level()) {
            ob_clean();
        }
        
        // Forcer les headers JSON
        http_response_code($httpCode);
        header('Content-Type: application/json; charset=UTF-8');
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        
        // Sortir le JSON et arrêter l'exécution
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit; // Important : arrêter l'exécution ici
    }
    

    public function uploadPhotos(array $files): string|false {
    try {
        $uploads = ImageService::uploadMultipleImages([
            'photoRecto' => $files['photoRecto'] ?? null,
            'photoVerso' => $files['photoVerso'] ?? null
        ], __DIR__ . '/../../public/images/uploads/');

        return json_encode([
            'recto' => $uploads['photoRecto']['url'],
            'verso' => $uploads['photoVerso']['url']
        ]);
    } catch (\Exception $e) {
        return false;
    }
}

}