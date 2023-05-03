// initiate var
const apiKey =
    "AAPKbf44d181f22a42ab8eab18ee8594c1ab-mLGQlEanJhV5GdtfTVlpq2-zOy2dKwx3aDOH5Wobbz9TY70NvcbbdPpPljMwQB-";
const link = $("#map-link");
const namaAlamat = $("#namaAlamat");
const alamat = $("#alamat");
const detailAlamat = $("#detailAlamat");
const kota = $("#kota");
const provinsi = $("#provinsi");
const kodePos = $("#kodePos");
const lat = $("#lat");
const lng = $("#lng");
const btnSubmit = $("#btnSubmit");

// modalvar
const idM = $("#idM");
const alamatM = $("#alamatM");
const detailAlamatM = $("#detailAlamatM");
const kotaM = $("#kotaM");
const provinsiM = $("#provinsiM");
const kodePosM = $("#kodePosM");
const latM = $("#latM");
const lngM = $("#lngM");
const btnSubmitM = $("#btnSubmitM");

// initiate map
var map = L.map("map").setView([-6.8616744, 107.5385868], 12);
var mapModal = L.map("mapModal").setView([-6.8616744, 107.5385868], 12);

// make layer to map
var results = L.layerGroup().addTo(map);
var results2 = L.layerGroup().addTo(map);
var resultP = L.layerGroup().addTo(map);

// make layer to modal map
var resultsModal = L.layerGroup().addTo(mapModal);

// initiate pop up
var popup = L.popup();

// set map
L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution:
        '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
}).addTo(map);

// set map modal
L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution:
        '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
}).addTo(mapModal);

// function callback map on click
function onMapClick(e) {
    results.clearLayers();
    L.esri.Geocoding.reverseGeocode({
        apikey: apiKey,
    })
        .latlng(e.latlng)
        .run(function (error, result) {
            if (error) {
                return;
            }
            results.addLayer(
                L.marker(result.latlng)
                    .addTo(map)
                    .bindPopup(result.address.Match_addr)
                    .openPopup()
            );
            link.attr(
                "href",
                "https://www.google.co.id/maps/search/" +
                    result.latlng.lat +
                    "," +
                    result.latlng.lng +
                    "/@" +
                    result.latlng.lat +
                    "," +
                    result.latlng.lng +
                    ",19z"
            );
            link.show();
            alamat.val(result.address.LongLabel);
            kota.val(result.address.City);
            provinsi.val(result.address.Region);
            kodePos.val(result.address.Postal);
            lat.val(result.latlng.lat);
            lng.val(result.latlng.lng);
        });
}

// function callback onmapclick modal
function onMapModalClick(e) {
    resultsModal.clearLayers();
    L.esri.Geocoding.reverseGeocode({
        apikey: apiKey,
    })
        .latlng(e.latlng)
        .run(function (error, result) {
            if (error) {
                return;
            }
            resultsModal.addLayer(
                L.marker(result.latlng)
                    .addTo(mapModal)
                    .bindPopup(result.address.Match_addr)
                    .openPopup()
            );
            alamatM.val(result.address.LongLabel);
            kotaM.val(result.address.City);
            provinsiM.val(result.address.Region);
            kodePosM.val(result.address.Postal);
            latM.val(result.latlng.lat);
            lngM.val(result.latlng.lng);
        });
}

// trigger map on click
map.on("click", onMapClick);
mapModal.on("click", onMapModalClick);

// function callback search location
const searchControl = L.esri.Geocoding.geosearch({
    position: "topright",
    placeholder: "Enter an address or place e.g. 1 York St",
    useMapBounds: false,
    providers: [
        L.esri.Geocoding.arcgisOnlineProvider({
            apikey: apiKey,
            nearby: {
                lat: -33.8688,
                lng: 151.2093,
            },
        }),
    ],
}).addTo(map);

// trigger search location
searchControl.on("results", function (data) {
    results.clearLayers();
    for (let i = data.results.length - 1; i >= 0; i--) {
        results.addLayer(L.marker(data.results[i].latlng));
        alamat.val(data.results[i].properties.LongLabel);
        kota.val(data.results[i].properties.City);
        provinsi.val(data.results[i].properties.Region);
        kodePos.val(data.results[i].properties.Postal);
        lat.val(data.results[i].latlng.lat),
            lng.val(data.results[i].latlng.lng),
            link.attr(
                "href",
                "https://www.google.co.id/maps/search/" +
                    data.results[i].latlng.lat +
                    "," +
                    data.results[i].latlng.lng +
                    "/@" +
                    data.results[i].latlng.lat +
                    "," +
                    data.results[i].latlng.lng +
                    ",19z"
            );
        link.show();
    }
});

// on submit form trigger
btnSubmit.click(function name() {
    $.ajax({
        type: "POST",
        url: "/store",
        data: {
            _token: $("#token").val(),
            alamat: alamat.val(),
            namaAlamat: namaAlamat.val(),
            detailAlamat: detailAlamat.val(),
            kota: kota.val(),
            provinsi: provinsi.val(),
            kodePos: kodePos.val(),
            lat: lat.val(),
            lng: lng.val(),
        },
    })
        .then((res) =>
            Swal.fire("Berhasil !", res.message, "success").then(function () {
                results.clearLayers();
                resultP.clearLayers();
                alamat.val("");
                namaAlamat.val("");
                detailAlamat.val("");
                kota.val("");
                provinsi.val("");
                kodePos.val("");
                lat.val("");
                lng.val("");
                fetchLoc();
            })
        )
        .catch((res) =>
            Swal.fire("Error code : " + res.status, res.statusText, "error")
        );
});

// on submit update form trigger
btnSubmitM.click(function name() {
    $.ajax({
        type: "POST",
        url: "/store",
        data: {
            _token: $("#token").val(),
            id: idM.val(),
            alamat: alamatM.val(),
            detailAlamat: detailAlamatM.val(),
            kota: kotaM.val(),
            provinsi: provinsiM.val(),
            kodePos: kodePosM.val(),
            lat: latM.val(),
            lng: lngM.val(),
        },
    })
        .then((res) =>
            Swal.fire("Berhasil !", res.message, "success").then(function () {
                resultsModal.clearLayers();
                results2.clearLayers();
                results.clearLayers();
                resultP.clearLayers();
                idM.val("");
                alamatM.val("");
                detailAlamatM.val("");
                kotaM.val("");
                provinsiM.val("");
                kodePosM.val("");
                latM.val("");
                lngM.val("");
                fetchLoc();
                $("#exampleModal").modal("hide");
            })
        )
        .catch((res) =>
            Swal.fire("Error code : " + res.status, res.statusText, "error")
        );
});

// trigger load data when page is loaded
$(window).on("load", fetchLoc());

// callback function when page is loaded
function fetchLoc() {
    $.ajax({
        type: "GET",
        url: "/get-loc",
    })
        .then((res) => {
            var latlngs = [];
            for (let i = 0; i < res.length; i++) {
                latlngs.push([res[i].lat, res[i].lng]);
                results2.addLayer(
                    L.marker({ lat: res[i].lat, lng: res[i].lng })
                        .addTo(map)
                        .bindPopup(res[i].namaAlamat)
                        .openPopup()
                        .on("click", function () {
                            link.text(
                                "Buka Alamat " +
                                    res[i].namaAlamat +
                                    " di google maps"
                            );
                            link.attr(
                                "href",
                                "https://www.google.co.id/maps/search/" +
                                    res[i].lat +
                                    "," +
                                    res[i].lng +
                                    "/@" +
                                    res[i].lat +
                                    "," +
                                    res[i].lng +
                                    ",19z"
                            );
                            link.show();

                            // handle modal
                            $("#exampleModalLabel").text(
                                "Ubah Alamat " + res[i].namaAlamat
                            );

                            idM.val(res[i].id);
                            alamatM.val(res[i].Alamat);
                            detailAlamatM.val(res[i].detailAlamat);
                            kotaM.val(res[i].kota);
                            provinsiM.val(res[i].provinsi);
                            kodePosM.val(res[i].kodePos);
                            latM.val(res[i].lat);
                            lngM.val(res[i].lng);

                            setTimeout(function () {
                                resultsModal.clearLayers();
                                mapModal.invalidateSize();
                                resultsModal.addLayer(
                                    L.marker({
                                        lat: res[i].lat,
                                        lng: res[i].lng,
                                    })
                                        .addTo(mapModal)
                                        .bindPopup(res[i].Alamat)
                                        .openPopup()
                                );
                            }, 200);
                            $("#exampleModal").modal("show");
                        })
                );
            }
            resultP.addLayer(L.polygon(latlngs, { color: "red" }).addTo(map));
        })
        .catch((res) =>
            Swal.fire("Error code : " + res.status, res.statusText, "error")
        );
}
