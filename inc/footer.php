		</div>
		<div class="footer">
			<?php
				echo "<div>" . "Last modified: " . date("F d Y H:i:s.", getlastmod()) . "</div>";
			?>
			<div class="account">
				
				<?php 
					//session_start();
					//if (isset($_SESSION['user'])) { ?>
			        	<a href="logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>     
			    <?php //} else { 
			    	echo "     ";?>
			    			<a href="login.php">Login</a>     
			    <?php //} ?>

			</div>

			  <p>
			    <a href="http://validator.w3.org/check?uri=referer"><img
			      src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
			  
					<a href="http://jigsaw.w3.org/css-validator/check/referer">
			    	<img style="border:0;width:88px;height:31px"
			        src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
			        alt="Valid CSS!" /></a>
			        
			 </p>
		
		</div>

	</body>

</html>
<?php
ob_end_flush();
?>