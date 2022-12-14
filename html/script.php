    <script src="js/jquery.js"></script>
    <script src="js/plugins.min.js"></script>
    <script src="js/functions.js"></script>
    <script src='js/myFunction.js'></script>
    <script>
$(document).ready(() => {
    subContent(".new-title", 25);
    subContent(".entry-content", 120);
    $("#box-gold").load("./box-gold.php");
    $("#box-coin").load("./box-coin.php");
});
    </script>