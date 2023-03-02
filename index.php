<?php

require './db_connect.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = $_POST['subject'];
    $option = $_POST['option'];
    $needs = $_POST['needs'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $otherContact = $_POST['otherContactWays'];
    $fullname = $_POST['fullname'];

    $sql = "INSERT INTO ticket (subject, category, needs, email, tel, otherContactWay, status, fullname) VALUES (:subject, :category, :needs, :email, :tel, :otherContactWays, 'pending', :fullname)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':subject', $subject);
    $stmt->bindParam(':category', $option);
    $stmt->bindParam(':needs', $needs);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':tel', $tel);
    $stmt->bindParam(':otherContactWays', $otherContact);
    $stmt->bindParam(':fullname', $fullname);
    var_dump($sql);
    $stmt->execute();

    $succesMessage = "Ticket sent!";

    header('Location: ./thankyou.php');
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Forgeware Solutions</title>
    <link rel="icon" type="image/x-icon" href="./assets/img/forgewarelogo.png">

</head>

<body>
    <div class="container">
        <nav>
            <div class="logo">Forgeware<b>.</b></div>
            <ul class="navItems">
                <li><a href="">Home</a></li>
                <li><a href="#our-services">Our services</a></li>
                <li><a href="#about-us">About us</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <div class="links">
                <a href=""><i class="fab fa-linkedin"></i></a>
                <a href=""><i class="fab fa-instagram"></i></a>
                <a href=""><i class="fab fa-twitter"></i></a>
            </div>
        </nav>

        <div class="wrapper">
            <div class="cols cols0">
                <span class="topline">Welcome</span>
                <h1>We <span class="multiText"></span></h1>
                <p>We are Forgeware, a tech/software company located in the Netherlands.</p>
                <div class="btns">
                    <button id="mainButton">Github</button>
                    <button id="mainButton2">Contact</button>
                </div>
            </div>
            <div class="cols cols1">
                <div class="imgbox">
                    <img src="" alt="splash" id="splash">
                    <img src="./assets/img/forgewarelogo.png" alt="forgeware logo">
                </div>
            </div>
        </div>
    </div>


    <!-- NEW SECTION #1 -->
    <section id="our-services" class="section1">
        <div class="container">
            <h2>Our Services</h2>
            <div class="services">
                <div class="service">
                    <i class="fas fa-pen-nib"></i>
                    <h3>Web Design</h3>
                    <p>
                        We can help you with the design of your website.
                    </p>
                </div>
                <div class="service">
                    <i class="fas fa-code"></i>
                    <h3>Software/Web Development</h3>
                    <p>
                        We can make customized software/websites to fit your needs. We mostly focus on the back-end, we can also deliver simple front-end.
                    </p>
                </div>
                <div class="service">
                    <i class="fas fa-server"></i>
                    <h3>ICT Support</h3>
                    <p>
                        Problems with your computer or other devices? Don't worry we can help your either remotely or on site.
                    </p>
                </div>
                <div class="service">
                    <i class="fas fa-cogs"></i>
                    <h3>Other problems?</h3>
                    <p>
                        We can also assist with other IT problems. Submit a ticket and we'll let you know how we can help!
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="about-us" class="section2">
        <div class="container">
            <h2>About us</h2>
            <div class="skills">
                <div class="skill">
                    <h3>Back-end</h3>
                    <div class="skillBar">
                        <div class="bar html"></div>
                    </div>
                </div>
                <div class="skill">
                    <h3>ICT Support</h3>
                    <div class="skillBar">
                        <div class="bar css"></div>
                    </div>
                </div>
                <div class="skill">
                    <h3>Front-end</h3>
                    <div class="skillBar">
                        <div class="bar js"></div>
                    </div>
                </div>
                <div class="skill">
                    <h3>Other</h3>
                    <div class="skillBar">
                        <div class="bar php"></div>
                    </div>
                </div>
            </div>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nihil delectus, ea deleniti eum pariatur nemo ipsam deserunt quaerat quisquam vitae et harum aliquam mollitia beatae illum ab? Quae, maiores error!</p>
        </div>
    </section>

    <!-- NEW SECTION #3 -->
    <section id="contact" class="section3">
        <div class="container">
            <h2>Contact</h2>
            <div class="form">
                <form action="./index.php" method="post">
                    <?php echo '<label>'.$succesMessage.'</label>' ?>
                    <label>Your full name:</label>
                    <input type="text" name="fullname" placeholder="Please give us your full name">
                    <label for="subject">Subject:</label>
                    <input type="text" name="subject" placeholder="What is it about?" required>
                    <label for="option">What's it for?</label>
                    <select name="option" required>
                        <option value="web-design">Web design</option>
                        <option value="software-web-dev">Software/web development</option>
                        <option value="ict">ICT Support</option>
                        <option value="other">Other problems</option>
                        <option value="question">Question</option>
                    </select>
                    <label for="needs">What do you want/need from us?</label>
                    <input type="text" name="needs" placeholder="Tell us a bit about what you want from us." required>
                    <label>Your e-mail:</label>
                    <input type="email" name="email" placeholder="Your email." required>
                    <label>Your phone number (not required):</label>
                    <input type="tel" name="tel" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
                    <label>Other ways of contacting (not required):</label>
                    <input type="text" name="otherContactWays" placeholder="Maybe something like discord? (not preffered).">
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </section>

    <!-- FOOTER
    <footer>
        <div class="container">
            <p>&copy; 2023 Forgeware</p>
        </div>
    </footer> -->
    <script src="./assets/script/script.js"></script>
</body>

</html>