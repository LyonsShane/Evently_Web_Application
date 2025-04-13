<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/style.css" rel="stylesheet">
	<link href="img/logo/logo.png" rel="icon">
    <title>Registration Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            padding: 1rem 2rem;
            background-color: #060c22;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
			text-align: center;

        }

        .logo {
            height: 40px;
            width: auto;
			max-height: 30px;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: row;
        }
		
		

        .cover-section {
            flex: 1;
            background-image: url('img/intro-bg.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 2rem;
            position: relative;
        }
		
        .cover-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(6, 12, 34, 0.8);
        }

        .cover-text {
            position: relative;
            z-index: 1;
        }

        .cover-text h1 {
            color: #fff;
			  font-family: "Raleway", sans-serif;
			  font-size: 40px;
			  font-weight: 600;
			  text-transform: uppercase;
        }
		
		.cover-text p {
            color: #ebebeb;
			font-weight: 500;
			font-size: 18px;
        }
		

        .register-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .btn {
            display: inline-block;
            padding: 1rem 2rem;
            margin: 0.5rem;
            min-width: 200px;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
			background-color: #2246F8;
        }

        .btn-primary {
            background-color: #2286F8;
            color: white;
        }

        .btn-secondary {
            background-color: #2286F8;
            color: white;
        }

        footer {
            text-align: center;
            padding: 1rem;
            background-color: #060c22;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-top: auto;
			max-height: 50px;
			color: white;
        }

        @media (max-width: 768px) {
            main {
                flex-direction: column;
            }

            .cover-section {
                min-height: 300px;
            }

            .cover-text h1 {
                font-size: 2rem;
            }

            .btn {
                min-width: 80%;
            }
        }
    </style>
</head>
<body>
    <header>
        <img src="img/logo 2.png" alt="Logo" class="logo">
    </header>

    <main>
        <section class="cover-section">
            <div class="cover-text">
                <h1>Welcome to Evently Registration</h1>
                <p>Join our growing community today and explore endless possibilities in event planning.</p>
            </div>
        </section>

        <section class="register-section">
            <a href="user_registration.php"><button class="btn btn-primary"><img src="img/user.png"><br>Register as User</button></a>
			<br>
            <a href="vendor_registration.php"><button class="btn btn-secondary"><img src="img/vendor.png"><br>Register as Vendor</button></a>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Your Evently. All rights reserved.</p>
    </footer>
</body>
</html>
