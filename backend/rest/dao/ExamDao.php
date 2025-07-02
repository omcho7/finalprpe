<?php

class ExamDao {

    private $conn;

    /**
     * constructor of dao class
     */
    public function __construct(){
        try {
          /** TODO
           * List parameters such as servername, username, password, schema. Make sure to use appropriate port
           */
          $servername = "localhost";
          $username = "root";
          $password = "";
          $dbname = "webfinal";
          $port = 3306;

          /** TODO
           * Create new connection
           */
          $this->conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          echo "Connected successfully";
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
    }

    /** TODO
     * Implement DAO method used to get customer information
     */
    public function get_customers(){
        try {
            $stmt = $this->conn->prepare("SELECT id, first_name, last_name, birth_date FROM customers");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }

    /** TODO
     * Implement DAO method used to get customer meals
     */
    public function get_customer_meals($customer_id) {
        try {
            $stmt = $this->conn->prepare("
                SELECT f.name as food_name, f.brand as food_brand, m.created_at as meal_date
                FROM meals m
                JOIN foods f ON m.food_id = f.id
                WHERE m.customer_id = ?
                ORDER BY m.created_at DESC
            ");
            $stmt->execute([$customer_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }

    /** TODO
     * Implement DAO method used to save customer data
     */
    public function add_customer($data){
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO customers (first_name, last_name, birth_date, status) 
                VALUES (?, ?, ?, '1')
            ");
            $stmt->execute([$data['first_name'], $data['last_name'], $data['birth_date']]);
            
            $customer_id = $this->conn->lastInsertId();
            
            $stmt = $this->conn->prepare("
                SELECT id, first_name, last_name, birth_date 
                FROM customers 
                WHERE id = ?
            ");
            $stmt->execute([$customer_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return null;
        }
    }

    /** TODO
     * Implement DAO method used to get foods report
     */
    public function get_foods_report(){
        try {
            $stmt = $this->conn->prepare("
                SELECT 
                    f.id,
                    f.name,
                    f.brand,
                    f.image_url as image,
                    fn_energy.quantity as energy,
                    fn_protein.quantity as protein,
                    fn_fat.quantity as fat,
                    fn_fiber.quantity as fiber,
                    fn_carbs.quantity as carbs
                FROM foods f
                LEFT JOIN food_nutrients fn_energy ON f.id = fn_energy.food_id AND fn_energy.nutrient_id = 1
                LEFT JOIN food_nutrients fn_protein ON f.id = fn_protein.food_id AND fn_protein.nutrient_id = 2
                LEFT JOIN food_nutrients fn_fat ON f.id = fn_fat.food_id AND fn_fat.nutrient_id = 3
                LEFT JOIN food_nutrients fn_fiber ON f.id = fn_fiber.food_id AND fn_fiber.nutrient_id = 5
                LEFT JOIN food_nutrients fn_carbs ON f.id = fn_carbs.food_id AND fn_carbs.nutrient_id = 4
                ORDER BY f.id
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }
}
?>
