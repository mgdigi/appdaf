<?php

namespace App\Controller;

use App\Core\App;
use App\Service\CitoyenService;
use App\Core\Abstract\AbstractController;

class CitoyenController  extends AbstractController
{
    private CitoyenService $citoyenService;

    public function __construct(CitoyenService $citoyenService)
    {
        $this->citoyenService = $citoyenService;
    }

    public function index()
    {
        try {
            $citoyens = $this->citoyenService->getAllCitoyens();
            $response = [
                'success' => true,
                'message' => 'Citoyens récupérés avec succès',
                'data' => $citoyens,
                'count' => count($citoyens)                                                                                                                                                                                                                                                                                                                                                                                                                     
            ];
            
            $this->renderJson($response, 200);
            
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Erreur lors de la récupération des citoyens',
                'error' => $e->getMessage()
            ];
            
            $this->renderJson($response, httpCode: 500);
        }
    }

    public function show($params = [])
    {
        try {
            $cni = $params['cni'] ?? null;
            
            if (!$cni) {
                $response = [
                    'success' => false,
                    'message' => 'ID du citoyen requis'
                ];
                $this->renderJson($response, 400);
                return;
            }

            $citoyen = $this->citoyenService->getCitoyenByCni($cni);
            
            if (!$citoyen) {
                $response = [
                    'success' => false,
                    'message' => 'Citoyen non trouvé'
                ];
                $this->renderJson($response, 404);
                return;
            }

            $response = [
                'success' => true,
                'message' => 'Citoyen récupéré avec succès',
                'data' => $citoyen
            ];
            
            $this->renderJson($response, 200);
            
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Erreur lors de la récupération du citoyen',
                'error' => $e->getMessage()
            ];
            
            $this->renderJson($response, 500);
        }
    }

}