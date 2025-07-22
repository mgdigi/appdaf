<?php
// use app\core\Singleton;
// use App\Repository\CitoyenRepository;

// class CitoyenService extends Singleton{

//     private CitoyenRepository $citoyenRepository;

//     public function __construct(){
//         $this->citoyenRepository = App::getDependency('citoyenRepo');
//     }


//     public function getCitoyenByCni(string $cni): array{ 
//         $citoyen = $this->citoyenRepository->findByCni($cni);
//         if($citoyen){
//             return $citoyen->toArray();
//         }
//         return [];
    
//     }

//     public function createCitoyen(array $data): array
//     {
//         $citoyen = Citoyen::toObject($data);
//         $citoyen = $this->citoyenRepository->create($citoyen);
//         return $citoyen->toArray();
//     }

//     public function getAllCitoyens(): array{
//         $citoyens = $this->citoyenRepository->findAll();
//         $citoyensArray = [];
//         foreach($citoyens as $citoyen){
//             $citoyensArray[] = $citoyen->toArray();
//         }
//         return $citoyensArray;
//     }

// } -->



namespace App\Controller;

use App\Core\Abstract\AbstractController;
use App\Service\CitoyenService;
use App\Core\App;

class CitoyenController extends AbstractController
{
    private CitoyenService $citoyenService;

    public function __construct()
    {
        parent::__construct();
        $this->citoyenService = App::getDependency('citoyenServ');
    }

    public function index()
    {
        $result = $this->citoyenService->getAllCitoyens();
        http_response_code($result['code']);
        $this->renderJson($result);
    }

    public function getByCni()
    {
        $cni = $_GET['cni'] ?? $_POST['cni'] ?? null;
        
        if (!$cni) {
            $result = [
                'data' => null,
                'statut' => 'error',
                'code' => 400,
                'message' => 'Le paramètre CNI est requis'
            ];
            http_response_code(400);
            $this->renderJson($result);
            return;
        }

        $result = $this->citoyenService->getCitoyenByCni($cni);
        http_response_code($result['code']);
        $this->renderJson($result);
    }

    public function create()
    {
        echo "Formulaire de création";
    }

    public function store()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (!$data) {
            $data = $_POST;
        }

        if (empty($data)) {
            $result = [
                'data' => null,
                'statut' => 'error',
                'code' => 400,
                'message' => 'Aucune donnée fournie'
            ];
            http_response_code(400);
            $this->renderJson($result);
            return;
        }

        $result = $this->citoyenService->createCitoyen($data);
        http_response_code($result['code']);
        $this->renderJson($result);
    }

    public function edit()
    {
        echo "Formulaire d'édition";
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo "Affichage du citoyen ID: " . $id;
        } else {
            echo "ID requis";
        }
    }
}
