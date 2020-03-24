<?php 
    /* ------------------------------------------------  */
    // Connection Data Base
    try {
    	$conn = new PDO("mysql:host=$host;dbname=$dbnm", $user, $pass);	
    	$conn->exec('set names utf8');
    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	// echo "Conexión Exitosa!";
    } catch (PDOException $e) {
    	echo "Error en la conexión: ".$e->getMessage();
    }
    /* ------------------------------------------------  */
    // Add Student
    function addStudent($names, $birthdate, $email, $password, $conn) {
        try {
            $sql = "INSERT INTO users (names, birthdate, email, password) VALUES (:names, :birthdate, :email, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindparam(":names", $names);
            $stmt->bindparam(":birthdate", $birthdate);
            $stmt->bindparam(":email", $email);
            $stmt->bindparam(":password", $password);
            if($stmt->execute()) {
                 return true;
            }else {
                return false;
            }
           
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    /* ------------------------------------------------  */
    //Login
    function login($email, $password, $conn){
        try {
            $sql = "SELECT * FROM users
                    WHERE email = :email
                    AND password = :password
                    LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindparam(":email", $email);
            $stmt->bindparam(":password", $password);
            $stmt->execute();
            if($stmt->rowCount()>0){
                $ur = $stmt -> fetch(PDO::FETCH_ASSOC);
                $_SESSION['message']="El estudiante ".$ur['names']." si esta registrado";
                $_SESSION['uid']=$ur['id'];
                $_SESSION['unames']=$ur['names'];
                $_SESSION['uphoto']=$ur['photo'];
                $_SESSION['urole']=$ur['role'];
                $_SESSION['ustatus']=$ur['status'];
                return true;
            }else{
                $_SESSION['error']="El estudiante no está registrado/Datos Incorrectos";
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            
        }
    }
    /* ------------------------------------------------  */
    //Listar estudiantes
    function listStudents($conn){
        try {
            $sql = "SELECT * FROM users
                    WHERE role = 'Student' ";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    /* ------------------------------------------------  */
    // Save Student
    function saveStudent($names, $birthdate, $email, $photo, $password, $conn) {
        try {
            $sql = "INSERT INTO users (names, birthdate, email, photo, password) VALUES (:names, :birthdate, :email, :photo, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindparam(":names", $names);
            $stmt->bindparam(":birthdate", $birthdate);
            $stmt->bindparam(":email", $email);
             $stmt->bindparam(":photo", $photo);
            $stmt->bindparam(":password", $password);
            if($stmt->execute()) {
                 return true;
            }else {
                return false;
            }
           
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
     /* ------------------------------------------------  */
    //Show Student
    function showStudent($id, $conn){
        try {
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindparam(":id", $id);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();   
        }
    }
    // Update Student
     function updateStudent($id, $names, $birthdate, $email, $photo, $conn) {
        try {
            if($photo != null){
                $sql = "UPDATE users SET names = :names, birthdate = :birthdate, email = :email,
                photo = :photo WHERE id = :id";
            } else {
                $sql = "UPDATE users SET names = :names, birthdate = :birthdate, email = :email WHERE id = :id";
            }
            $stmt = $conn->prepare($sql);
            $stmt->bindparam(":id", $id);
            $stmt->bindparam(":names", $names);
            $stmt->bindparam(":birthdate", $birthdate);
            $stmt->bindparam(":email", $email);
            if($photo != null){
             $stmt->bindparam(":photo", $photo);
            }
            if($stmt->execute()) {
                 return true;
            }else {
                return false;
            }
           
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    //*--------------------------------------------------------*
    function deleteStudent($id, $conn) {
            try {
                $sql = "DELETE FROM users WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindparam(":id", $id);
                if($stmt->execute()) {
                     return true;
                }else {
                    return false;
                }
               
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        //*----------------------------------------*
        // Update Subject
         function updateSubject( $id, $name, $conn) {
            try {
                $sql = "UPDATE subjects SET name = :name WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindparam(":id", $id);
                $stmt->bindparam(":name", $name);
                if($stmt->execute()) {
                     return true;
                }else {
                    return false;
                }
               
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        //*-------------------------------*
        // Delete Subject
        function deleteSubject($id, $conn) {
                try {
                    $sql = "DELETE FROM subjects WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindparam(":id", $id);
                    if($stmt->execute()) {
                         return true;
                    }else {
                        return false;
                    }
                   
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            }
        /* ------------------------------------------------  */
        //Show Subject
        function showSubject($id, $conn){
            try {
                $sql = "SELECT * FROM subjects WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindparam(":id", $id);
                $stmt->execute();
                return $stmt->fetchAll();
            } catch (PDOException $e) {
                echo $e->getMessage();   
            }
        }
        //*---------------------------------------*
        // Save Subject
        function saveSubject($id, $name, $conn) {
            try {
                $sql = "INSERT INTO subjects (id, name) VALUES (:id, :name)";
                $stmt = $conn->prepare($sql);
                $stmt->bindparam(":id", $id);
                $stmt->bindparam(":name", $name);
                if($stmt->execute()) {
                     return true;
                }else {
                    return false;
                }
               
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        /* ------------------------------------------------  */
        //Listar Materias
        function listSubject($conn){
            try {
                $sql = "SELECT * FROM subjects";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        /* ------------------------------------------------  */
        //Listar estudiantes
        function listNotes($conn){
            try {
                $sql = "SELECT n.*, u.names AS uname, s.name AS sname,
                        (n.nt1+n.nt2+n.nt3)/3 AS fnote
                        FROM notes AS n, users AS u, subjects AS s
                        WHERE n.user_id = u.id
                        AND n.subject_id = s.id";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        /* ------------------------------------------------  */
        // Verify note
        function verifyNote($subject_id, $user_id, $conn){
            try {
                $sql = "SELECT id FROM notes
                        WHERE user_id = :user_id
                        AND subject_id = :subject_id
                        LIMIT 1";
                $stmt = $conn->prepare($sql);
                $stmt->bindparam(":user_id", $user_id);
                $stmt->bindparam(":subject_id", $subject_id);
                $stmt->execute();
                if($stmt->rowCount() > 0){
                    $ur = $stmt -> fetch(PDO::FETCH_ASSOC);
                    return false;
                } else{
                    return true;
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
                
            }
        }
        /* ------------------------------------------------  */
        // Add Note
        function saveNote($subject_id, $user_id, $nt1, $nt2, $nt3, $conn) {
            try {
                if(verifyNote($subject_id, $user_id, $conn)){
                    $sql = "INSERT INTO notes (nt1, nt2, nt3, user_id, subject_id) VALUES (:nt1, :nt2, :nt3, :user_id, :subject_id)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindparam(":nt1", $nt1);
                    $stmt->bindparam(":nt2", $nt2);
                    $stmt->bindparam(":nt3", $nt3); 
                    $stmt->bindparam(":user_id", $user_id);
                    $stmt->bindparam(":subject_id", $subject_id);
                    if($stmt->execute()) {
                         return true;
                    }else {
                        return false;
                    }
                }else{
                    $_SESSION['error'] = "El estudiante ya tiene notas en esta Materia";
                    return false;
                }
               
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
         /* ------------------------------------------------  */
        //Mostar Materia
        function showNotes($id, $conn){
            try {
                $sql = "SELECT n.*, u.names AS uname, u.photo, s.name AS sname,
                        (n.nt1+n.nt2+n.nt3)/3 AS fnote
                        FROM notes AS n, users AS u, subjects AS s
                        WHERE n.user_id = u.id
                        AND n.subject_id = s.id
                        AND n.id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindparam(":id", $id);
                $stmt->execute();
                return $stmt->fetchAll();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        //*-------------------------------*
        // Delete Subject
        function deleteNote($id, $conn) {
                try {
                    $sql = "DELETE FROM notes WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindparam(":id", $id);
                    if($stmt->execute()) {
                         return true;
                    }else {
                        return false;
                    }
                   
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            }
        /*------------------------------------------------------------------------------------*/
         // Actualizar
         function updateNote($id, $subject_id, $user_id, $nt1, $nt2, $nt3, $conn){
          try {
              $sql = "UPDATE notes SET nt1 = :nt1, nt2 = :nt2, nt3 = :nt3, user_id = :user_id, subject_id = :subject_id WHERE id = :id";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindparam(':id', $id);
            $stmt->bindparam(':nt1',$nt1);
            $stmt->bindparam(':nt2',$nt2 );
            $stmt->bindparam(':nt3',$nt3 );
            $stmt->bindparam(":user_id", $user_id);
            $stmt->bindparam(':subject_id', $subject_id);
            $stmt->execute();
            if($stmt->execute()){
              return true;
            }else{
              return false;
            }
            
          } catch (PDOException $e) {
            echo $e->getMessage();
          }
         }