<?php
/**
 * Grading class
 * 
 * @author  Arturo Mora-Rioja
 * @version 1.0, March 2022
 */

    require_once 'db.php';

    class Grade extends DB {
        const DENMARK = 'Denmark';
        const USA = 'USA';
        
        function convert(string $grade, string $system) {
            try {                
                $destinationSystem = 'c' . ($system === Grade::DENMARK ? Grade::USA : Grade::DENMARK);
                $system = "c$system";

                $sql =<<<SQL
                    SELECT $destinationSystem
                    FROM grades
                    WHERE $system = ?;
                SQL;
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$grade]);

                if ($results = $stmt->fetch()) {
                    $results = $results[$destinationSystem];
                } else {
                    $results = 'Invalid value';
                }

                $this->disconnect();

                return $results;
            } catch (\PDOException $e) {
                echo 'Database error';
                die('Database error: ' . $e->getMessage());
            }
        }
    }

?>