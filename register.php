
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
   
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    
  <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 100%;
            max-width: 450px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-size: 14px;
            margin-bottom: 5px;
            color: #555;
        }
        input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            padding: 10px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .form-toggle {
            text-align: center;
            margin-top: 10px;
        }
        .form-toggle a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }
        .form-toggle a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

  <?php 
  $website = "THis is my website";

  
  function getWebsite(){
    global $website;
    return $website;
  }

  echo getWebsite(); ?>
<div class="container mt-5 bg-danger">

    <h2>Create Account</h2>
    <form method="POST" action="save_user.php">
        <label>Username:</label>
        <input type="text" name="username" required>
        
          <label>Password:</label>
        <input type="password" name="password" required>

               
          <label>Date of Birth:</label>
        <input type="date" name="dob" required>

        <label>Contact:</label>
        <input type="number" name="contact_no" required>
        
        <label>Age:</label>
        <input type="nummber" name="age" required>

        <button type="submit">Register</button>
    </form>
    <div class="form-toggle">
        <p>Already have an account? <a href="index.php">Login here</a></p>
    </div>
</div>
</body>
</html>