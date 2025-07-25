<?php 
namespace App\Repository;

use App\Core\Abstract\AbstractRepository;


class JournalRepository extends AbstractRepository implements IJournalRepository{

    private string $table = 'journalisation';

    public function __construct(){
        parent::__construct();
    }

    public function insert($data){

        $sql = "Insert into $this->table (date, heure, localisation, ipadress, status, citoyenId) VALUES (:date, :heure, :localisation, :ipadress, :status, :citoyenId)";
        $stmt = $this->pdo->prepare($sql);
        return  $stmt->execute($data);

    }


}