<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maps App</title>
    <!-- CDN CSS Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />


    <!-- CDN JS Leaflet-->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="https://unpkg.com/esri-leaflet@3.0.10/dist/esri-leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@3.1.4/dist/esri-leaflet-geocoder.css" crossorigin="" />
    <script src="https://unpkg.com/esri-leaflet-geocoder@3.1.4/dist/esri-leaflet-geocoder.js" crossorigin=""></script>


    <!-- CDN CSS Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom Styling -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

</head>

<body>
    <div class="row container-fluid">
        <div class="col-8 mx-auto">
            <form class="row g-3 my-4 shadow p-4 pb-5 rounded bg-white">
                <h3 class="text-center">Rekap lokasi terpenting anda</h3>
                <hr class="shadow">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="col-12">
                    <div id="map" class="shadow rounded"></div>
                    <div class="text-center mt-2">
                        <a href="" id="map-link" target="_blank">Buka di google maps</a>
                    </div>
                </div>
                <div class="col-12">
                    <label for="namaAlamat" class="form-label">Nama Alamat</label>
                    <input type="text" class="form-control" id="namaAlamat" placeholder="Rumah aku..">
                </div>
                <div class="col-12">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" placeholder="CImahi..">
                </div>
                <div class="col-12">
                    <label for="detailAlamat" class="form-label">Detail alamat</label>
                    <input type="text" class="form-control" id="detailAlamat" placeholder="Rumah warna kuning...">
                </div>
                <div class="col-md-6">
                    <label for="kota" class="form-label">kecamatan</label>
                    <input type="text" class="form-control" id="kota" placeholder="bandung ..">
                </div>
                <div class="col-md-4">
                    <label for="provinsi" class="form-label">provinsi</label>
                    <input type="text" class="form-control" id="provinsi" placeholder="jawa barat ..">
                </div>
                <div class="col-md-2">
                    <label for="kodePos" class="form-label">Pos</label>
                    <input type="number" class="form-control" id="kodePos" placeholder="50422">
                </div>
                <input type="hidden" name="lat" id="lat">
                <input type="hidden" name="lng" id="lng">
                <div class="col-12">
                    <button type="button" id="btnSubmit" class="btn btn-primary">Simpan Alamat</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal  fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="idM">
                        <div class="col-12 rounded" id="mapModal">
                        </div>
                        <div class="col-12">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamatM" placeholder="CImahi..">
                        </div>
                        <div class="col-12">
                            <label for="detailAlamat" class="form-label">Detail alamat</label>
                            <input type="text" class="form-control" id="detailAlamatM" placeholder="Rumah warna kuning...">
                        </div>
                        <div class="col-md-5">
                            <label for="kota" class="form-label">kecamatan</label>
                            <input type="text" class="form-control" id="kotaM" placeholder="bandung ..">
                        </div>
                        <div class="col-md-4">
                            <label for="provinsi" class="form-label">provinsi</label>
                            <input type="text" class="form-control" id="provinsiM" placeholder="jawa barat ..">
                        </div>
                        <div class="col-md-3">
                            <label for="kodePos" class="form-label">Pos</label>
                            <input type="number" class="form-control" id="kodePosM" placeholder="50422">
                        </div>
                        <input type="hidden" name="lat" id="latM">
                        <input type="hidden" name="lng" id="lngM">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSubmitM">Simpan perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- CDN Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>

    <!-- CDN JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- CDN SWAL 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/map.js') }}"></script>
</body>

</html>