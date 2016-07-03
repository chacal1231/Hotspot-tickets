<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/
?>

			</div>
		</div>
		<script src="theme/js/jquery.js"></script>
		<script src="theme/js/bootstrap.min.js"></script>
		<script>
			$('#btn1').click(function() {
			$('#first_form').toggle();
			$('#second_form').hide();
			$('#third_form').hide();
			});
			
			$('#btn2').click(function() {
			$('#second_form').toggle();
			$('#first_form').hide();
			$('#third_form').hide();
			});
			
			$('#btn3').click(function() {
			$('#third_form').toggle();
			$('#first_form').hide();
			$('#second_form').hide();
			});
      </script>
   </body>
</html>