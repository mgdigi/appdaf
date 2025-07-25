<?php 
namespace App\Repository;

use App\Core\Abstract\AbstractRepository;


class JournalRepository extends AbstractRepository implements IJournalRepository{

    private string $table = 'journalisation';

    public function __construct(){
        parent::__construct();
    }

    public function insert($data){
    $sql = "INSERT INTO $this->table (date, heure, localisation, ipadress, status, citoyenId) 
            VALUES (:date, :heure, :localisation, :ipadress, :status, :citoyenId)";
    
    $stmt = $this->pdo->prepare($sql);
    
    $params = [
        ':date' => $data['date'],
        ':heure' => $data['heure'] ?? date('Y-m-d H:i:s'), 
        ':localisation' => $data['localisation'],
        ':ipadress' => $data['ipadress'],
        ':status' => (int)$data['status'], 
        ':citoyenId' => $data['citoyenId'] 
    ];
    
    return $stmt->execute($params);
}


}