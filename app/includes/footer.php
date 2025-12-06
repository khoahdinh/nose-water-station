<div class="footer">
    <div class="footer-content">

        <div class="footer-section about">
            <!-- <h1 class="logo-text"><span>Lazy</span>Hub</h1> -->
            <a href="index.php"><img src="<?php echo BASE_URL . '/assets/images/icon/icon.png'; ?>" alt="icon"></a>
            <p><?php echo $text['Welcome']; ?></p>
            <div class="contact">
                <span><i class="fas fa-phone"></i> &nbsp; 093-569-xxxx</span>
                <span><i class="fas fa-envelope"></i> &nbsp; nosewater.station@gmail.com</span>
            </div>
            <div class="socials">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>

        <div class="footer-section links">
            <h2><?php echo $text['Quick_links']; ?></h2>
            <br>
            <ul>
                <a href="">
                    <li><?php echo $text['Home'];  ?></li>
                </a>
                <a href="story">
                    <li><?php echo $text['Photo'];  ?></li>
                </a>
                <a href="about">
                    <li><?php echo $text['About'];  ?></li>
                </a>
                <a href="terms-and-conditions">
                    <li><?php echo $text['Term_and_condition'];  ?></li>
                </a>
            </ul>
        </div>

        <div class="footer-section contact-form">
            <h2><?php echo $text['Contact_Us'];  ?></h2>
            <br>

            <form action="contact_process.php" method="post">
                <input type="email" name="email" class="text-input contact-input"
                    placeholder="<?php echo $text['Your_Email'];  ?>">
                <textarea rows="4" name="message" class="text-input contact-input"
                    placeholder="<?php echo $text['Your_Message'];  ?>"></textarea>
                <button type="submit" class="btn btn-big contact-btn">
                    <i class="fas fa-envelope"></i>
                    <?php echo $text['Send_button'];  ?>
                </button>
            </form>

        </div>

    </div>

    <div class="footer-bottom">
        &copy; 2024 Lazyhub | <a href="privacy-policy"><?php echo $text['Privacy_Policy'];  ?></a>
    </div>
</div>