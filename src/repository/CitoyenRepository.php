<?php 
namespace App\Repository;

use ICitoyenRepository;
use \PDOException;

use App\Core\Abstract\AbstractRepository;
use App\Entity\Citoyen;

class CitoyenRepository extends AbstractRepository {

    private string $table = 'citoyen';
    
    public function __construct(){
        parent::__construct();
    }
   public function selectAll():array{
     try{
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute();
       
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        
     }catch (Exception $e) {
        error_log("Erreur de  recuperation des citoyens : " . $e->getMessage());
    }
   }
     public function insert(array $data){        
     }

    //  public function selectByCni(string $cni): ?Citoyen{
    //     try{

    //     }
    //  }
    

      

   

    

}