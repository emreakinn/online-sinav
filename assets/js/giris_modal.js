document.addEventListener("DOMContentLoaded", function () {
    var btn = document.getElementById('girisYapBtn');
    if (btn) {
        btn.addEventListener('click', function () {
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.show();
        });
    }
});