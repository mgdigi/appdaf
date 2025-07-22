<?php 


use App\Controller\CitoyenController;

return [
    ['GET', '/api/citoyen/{nci}', [CitoyenController::class, 'citoyenByNci']],
    ['GET', '/api/citoyens', [CitoyenController::class, 'index']],
];