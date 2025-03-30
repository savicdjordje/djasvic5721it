</div>

<footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">
    <i class="fa fa-facebook-official w3-hover-opacity"></i>
    <i class="fa fa-instagram w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>
    <p class="w3-medium">&copy; <?= date("Y") ?> AutoLak Servis | Izradio: Djordje Savic, 17/2021 IT</p>
</footer>

<script>
function myFunction() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}
</script>

<script>
    tinymce.init({
        selector: 'textarea.tinymce',
        height: 300,
        menubar: false,
        plugins: 'link image code lists',
        toolbar: 'undo redo | bold italic underline | bullist numlist | link image | code',
        branding: false
    });
</script>

</body>
</html>