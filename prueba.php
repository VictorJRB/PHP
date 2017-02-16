<?php
require_once ('funciones.php');
?>
<html>
<head>
    <script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
    <script>
        $(document).ready(parpadear);
        function parpadear(){ $('.parp').fadeIn(500).delay(250).fadeOut(500, parpadear) }

    </script>


</head>

<body>
<div class="parp">SoyJoaquin.</div>
</body>
</html>