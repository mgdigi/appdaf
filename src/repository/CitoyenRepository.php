<?php 
namespace App\Repository;

use Cloudinary\Exception\Error;
use App\Repository\JournalRepository;
use \PDOException;
use App\Entity\Citoyen;

use App\Repository\ICitoyenRepository;
use App\Core\Abstract\AbstractRepository;

class CitoyenRepository extends AbstractRepository implements ICitoyenRepository{

    private string $table = 'citoyen';
    private JournalRepository $journalRepository;
    
    public function __construct(JournalRepository $journalRepository){
        parent::__construct();
        $this->journalRepository = $journalRepository;
    }
   public function selectAll():array{
     try{
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
     
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
     }catch (\Exception $e) {
        throw new PDOException($e->getMessage());
     }
    }
     public function insert($citoyen){        
     }

     public function selectByCni(string $cni): ?array 
{
    $this->pdo->beginTransaction();
    
    try {
        $sql = "SELECT * FROM $this->table WHERE numerocni = :cni";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['cni' => $cni]);
        $citoyenData = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($citoyenData) {
            $citoyenId = $citoyenData['id'];

            $this->journalRepository->insert([
                'date' => date('Y-m-d'),
                'heure' => (new \DateTime())->format('Y-m-d H:i:s'),
                'localisation' => 'Dakar',
                'ipadress' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1', 
                'status' => 1, 
                'citoyenId' => $citoyenId,
            ]);
            
            $this->pdo->commit();
            return $citoyenData;
        } else {
            $this->journalRepository->insert([
                'date' => date('Y-m-d'),
                'heure' => (new \DateTime())->format('Y-m-d H:i:s'),
                'localisation' => 'Dakar',
                'ipadress' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                'status' => 0, 
                'citoyenId' => null, 
            ]);
            
            $this->pdo->commit();
            return null;
        }
        
    } catch (\Exception $e) {
        $this->pdo->rollBack();
        throw new \Exception("Erreur lors de la recherche du citoyen : " . $e->getMessage());
    }
}




   

    

}