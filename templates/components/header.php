 <header class="header">

   <a href="../pages/home.php" class="header_logo">
       <span>MindfulCare</span>
       <img src="../../images/logo.png" alt="logo" class="header_logo_image">
   </a>

     <nav class="nav">
         <ul class="navList">
             <?php if (isset($_SESSION['user'])) : ?>
                 <li class = "navLink_container">
                     <button id="logout-btn" class = "logout-btn">Logout</button>
                 </li>
                 <li class="navLink_container">
                     <a href="../pages/specialists.php">Our specialists</a>
                 </li>
                 <li class="navLink_container">
                     <a href="../pages/feedback.php">Leave a feedback</a>
                 </li>
                 <li class="navLink_container">
                     <a href="../pages/appointment.php">Make an appointment</a>
                 </li>
                 <li class="navLink_container">
                     <a href="../pages/accounts.php">My account</a>
                 </li>
             <?php else : ?>
                 <li class="navLink_container">
                     <a href="../pages/login.php">Log in</a>
                 </li>
                 <li class="navLink_container">
                     <a href="../pages/signin.php">Sign in</a>
                 </li>
                 <li class="navLink_container">
                     <a href="../pages/specialists.php">Our specialists</a>
                 </li>
                 <li class="navLink_container">
                     <a href="../pages/feedback.php">Leave a feedback</a>
                 </li>
                 <li class="navLink_container">
                     <a href="../pages/appointment.php">Make an appointment</a>
                 </li>

             <?php endif; ?>
         </ul>
     </nav>
 </header>