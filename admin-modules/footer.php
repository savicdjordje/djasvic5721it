    </main>

    <footer class="bg-light text-center py-3 mt-5">
        <p>&copy; <?= date("Y") ?> AutoLak Servis | Izradio: Djordje Savic, 17/2021 IT</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
