document.getElementById('yeniSoruEkleBtn').addEventListener('click', function () {
    const sorular = document.getElementById('sorular');

    const yeniSoruDiv = document.createElement('div');
    yeniSoruDiv.classList.add('soru-blok', 'mb-4');

    yeniSoruDiv.innerHTML = `
    <div class="col-12 my-2">
        <textarea name="soru[]" placeholder="Soru Yaz..." rows="4" class="w-100" required></textarea>
    </div>
    <div class="col-12 mb-2">
        <div class="row justify-content-between">
            <div class="col-md-2">
                <input type="text" name="a[]" placeholder="A Şıkkı" class="form-control" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="b[]" placeholder="B Şıkkı" class="form-control" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="c[]" placeholder="C Şıkkı" class="form-control" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="d[]" placeholder="D Şıkkı" class="form-control" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="e[]" placeholder="E Şıkkı" class="form-control" required>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="dogru[]" placeholder="Doğru Cevap" class="form-control" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="puan[]" placeholder="Puan" class="form-control" required>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-danger form-control soru-sil">Sil</button>
            </div>
        </div>
    </div>
    <hr>
        `;

    sorular.appendChild(yeniSoruDiv);
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('soru-sil')) {
        e.target.closest('.soru-blok').remove();
    }
});
