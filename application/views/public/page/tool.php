<!DOCTYPE html>
<html lang="id">

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-cog me-2"></i>Generate URL Tamu</h4>
            </div>
            <div class="card-body pb-4">
                <div class="row">
                    <form action="#" method="post" id="generateForm" class="col-md-6">
                        <div class="form-group mb-2">
                            <label class="form-label" for="namaPasangan">Nama Tamu</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="namaPasangan" id="namaPasangan" required>
                                <button type="button" class="btn btn-primary" onclick="generateURL()"><i class="fas fa-paper-plane fs-6 me-2"></i>Submit</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group mb-2 col-md-6">
                        <label class="form-label">Hasil URL</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="hasilURL" readonly>
                            <button class="btn btn-success" type="button" onclick="copyToClipboard()"><i class="fas fa-copy fs-6 me-2"></i>Copy</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function generateURL() {
        var namaPasangan = document.getElementById('namaPasangan').value;
        var encodedNamaPasangan = encodeURIComponent(namaPasangan);

        var generatedURL = 'https://wedding.herupedia.id/oni-alex/?to=' + encodedNamaPasangan;

        // Tampilkan hasil URL di input dengan id 'hasilURL'
        document.getElementById('hasilURL').value = generatedURL;
    }

    function copyToClipboard() {
        var hasilURL = document.getElementById('hasilURL');
        hasilURL.select();
        document.execCommand('copy');
        alert('URL telah disalin ke clipboard');
    }
</script>

</html>