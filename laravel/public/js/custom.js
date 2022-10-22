if (typeof authorized === 'undefined') {
    var authorized = false
}

if (typeof edit === 'undefined') {
    var edit = false
}

if (typeof owner === 'undefined') {
    var owner = false
}

if (typeof session_message === 'undefined') {
    var session_message = false
}

if (typeof property_details  === 'undefined') {
    var property_details  = false
}

if (typeof save  === 'undefined') {
    var save  = false
}


if (typeof center  === 'undefined') {
    var center  = [23.785737507723276, -269.5839357376099]
}

if (typeof home  === 'undefined') {
    var home  = false
}

var map = null;

var markerdata = []
var markers = []

$(document).ready(function() {

    if (authorized) {
        check_notifications()
    }

    if (session_message) {
        $.toast({
            heading: session_message_text,
            showHideTransition: 'fade',
            icon: session_message_icon
        })
    }

    if (home || save || owner || property_details) {
        create_map(property_details ? 17 : 15)
    }

    if (property_details) {
        property_carousel()
    }


    if (home || save) {
        search_page()
    }

        
    if (edit) {
        $("select").each(function() {
            var v = $(this).data('val')
            if (v) {
                var t = $(this)
                var delay = t.data('delay')
                if (!delay) {
                    t.val(v)
                    t.change()
                } else {
                    setTimeout(function() {
                        t.val(v)
                        console.log(delay)
                    }, delay)
                }
            }
        })

        let img_urls = $("#images").val().split("~-~")
        img_urls.forEach(function(v) {
            $(".selected-images").append("<div class='selected-img' data-img='" + v + "'><img src='" + v + "' /><span class='remove_img'>×</span></div>")
        })
        setup_remover()
    }

    
})


function upload_file(e) {
    e.preventDefault();
    ajax_file_upload(e.dataTransfer.files);
}

function file_explorer() {
    document.getElementById('selectfile').click();
    document.getElementById('selectfile').onchange = function() {
        files = document.getElementById('selectfile').files;
        ajax_file_upload(files);
    };
}

function ajax_file_upload(files_obj) {
    if (files_obj != undefined) {
        var form_data = new FormData();
        for (i = 0; i < files_obj.length; i++) {
            form_data.append('file[]', files_obj[i]);
        }
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "/api/file-upload", true);
        xhttp.onload = function(event) {
            if (xhttp.status == 200) {
                let resp = JSON.parse(this.response)
                if (resp.success) {
                    let new_img_urls = JSON.parse(this.response).file

                    update_images(new_img_urls)
                    new_img_urls.forEach(function(v) {

                        setup_remover()
                    })
                } else {
                    $.toast({
                        heading: 'Error',
                        text: resp.message,
                        showHideTransition: 'fade',
                        icon: 'error'
                    })
                }
            } else {
                console.log(this.responseText)
            }
        }

        xhttp.send(form_data);
    }
}

function setup_remover() {
    $(".remove_img").on('click', function() {
        let img_urls = $("#images").val().split("~-~")
        let rem = $(this).parent().data('img')
        img_urls.forEach(function(v, i) {
            if (v === '' || v === rem) {
                img_urls.splice(i, 1);
            }
        })
        $("#images").val(img_urls.join("~-~"))
        $(this).parent().remove()
    })
}


function update_images(arr) {
    let img_urls = $("#images").val()
    arr.forEach(function(v) {
        $(".selected-images").append("<div class='selected-img' data-img='" + v + "'><img src='" + v + "' /><span class='remove_img'>×</span></div>")
        let img_urls = $("#images").val() + "~-~" + v
        img_urls = img_urls.split("~-~")
        img_urls.forEach(function(v, i) {
            if (v === '') {
                img_urls.splice(i, 1);
            }
        })
        $("#images").val(img_urls.join("~-~"))
    })

}

$("#district").on('change', function(v) {
    var val = cities[$(this).val()].split("\n")
    $("#city").html("<option value=''>Select City</option>")
    val.forEach(function(v) {
        $("#city").append("<option value='" + v + "'>" + v + "</option>")
    })
})

$("#property_type_changer").on('change', function() {
    $("#cost").attr('placeholder', 'Cost (Tk)')
    var v = $(this).val()
    $(".property_type_fields").hide()
    if (v === 'Flat' || v === 'Rent') {
        $(".property_type_fields.flat_details, .property_type_fields.house_details").fadeIn()
        if (v === 'Rent') {
            $("#cost").attr('placeholder', 'Cost (Tk per Month)')
        }
    } else {
        $(".property_type_fields.house_details").fadeIn()
    }
})

$("#create-listing").submit(function(e) {
    e.preventDefault()
    if (!$("#images").val()) {
        $.toast({
            heading: 'Error',
            text: 'Please add minimum 1 image',
            showHideTransition: 'fade',
            icon: 'error'
        })
    } else if (!$("#lat_lng").val()) {
        $.toast({
            heading: 'Error',
            text: 'Please add location on the map',
            showHideTransition: 'fade',
            icon: 'error'
        })
    } else {
        var data = $("#create-listing").serialize();
        $(this).off('submit').submit();
    }
})

function manual_upload() {
    document.getElementById('selectfile').click();
    document.getElementById('selectfile').onchange = function() {
        files = document.getElementById('selectfile').files;
        ajax_file_upload(files);
    };
}

function create_map(zoom = 15) {

    map = L.map('map', {
        renderer: L.canvas()
    }).setView(center, zoom)
    

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Data © <a href="http://osm.org/copyright">OpenStreetMap</a>',
            maxZoom: 18
        }).addTo(map);

    if (owner) {
        map.on('click', onMapClick);
    }

    if (edit || property_details) {
        L.marker(center).addTo(map)
    }
}

function clearmap() {
    for (i in map._layers) {
        if (map._layers[i].editing != undefined) {
            try {
                map.removeLayer(map._layers[i]);
            } catch (e) {
                console.log("problem with " + e + map._layers[i]);
            }
        }
    }
}

function onMapClick(e) {
    clearmap()
    var geojsonFeature = {
        "type": "Feature",
        "properties": {},
        "geometry": {
            "type": "Point",
            "coordinates": [e.latlng.lat, e.latlng.lng]
        }
    }
    if (markers.length > 0) {
        map.removeLayer(markers.pop());
    }
    var marker;

    L.geoJson(geojsonFeature, {

        pointToLayer: function(feature, latlng) {

            marker = L.marker(e.latlng, {

                title: "Resource Location",
                alt: "Resource Location",
                riseOnHover: true,
                draggable: true,

            });
            markers.push(marker)

            return marker;
        }
    }).addTo(map);

    let lat = marker.getLatLng().lat
    let lng = marker.getLatLng().lng
    $("#lat_lng").val(lat + "," + lng)

}

function property_carousel() {
    var bigimage = $("#big");
    var thumbs = $("#thumbs");
    var syncedSecondary = true;

    bigimage
        .owlCarousel({
            items: 1,
            slideSpeed: 2000,
            nav: true,
            autoplay: true,
            dots: false,
            loop: true,
            responsiveRefreshRate: 200,
            navText: [
                '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                '<i class="fa fa-chevron-right" aria-hidden="true"></i>'
            ]
        })
        .on("changed.owl.carousel", syncPosition);

    thumbs
        .on("initialized.owl.carousel", function() {
            thumbs
                .find(".owl-item")
                .eq(0)
                .addClass("current");
        })
        .owlCarousel({
            items: 4,
            dots: true,
            nav: true,
            navText: [
                '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                '<i class="fa fa-chevron-right" aria-hidden="true"></i>'
            ],
            smartSpeed: 200,
            slideSpeed: 500,
            slideBy: 4,
            responsiveRefreshRate: 100
        })
        .on("changed.owl.carousel", syncPosition2);

    function syncPosition(el) {
        var count = el.item.count - 1;
        var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

        if (current < 0) {
            current = count;
        }
        if (current > count) {
            current = 0;
        }
        thumbs
            .find(".owl-item")
            .removeClass("current")
            .eq(current)
            .addClass("current");
        var onscreen = thumbs.find(".owl-item.active").length - 1;
        var start = thumbs
            .find(".owl-item.active")
            .first()
            .index();
        var end = thumbs
            .find(".owl-item.active")
            .last()
            .index();

        if (current > end) {
            thumbs.data("owl.carousel").to(current, 100, true);
        }
        if (current < start) {
            thumbs.data("owl.carousel").to(current - onscreen, 100, true);
        }
    }

    function syncPosition2(el) {
        if (syncedSecondary) {
            var number = el.item.index;
            bigimage.data("owl.carousel").to(number, 100, true);
        }
    }

    thumbs.on("click", ".owl-item", function(e) {
        e.preventDefault();
        var number = $(this).index();
        bigimage.data("owl.carousel").to(number, 300, true);
    });

}

function showMarkers() {
    markerdata.forEach(function(v) {
        var marker = L.marker([v.lat, v.long]).addTo(map).on('click', function(e) {
            $(".result-item").removeClass("selected")
            $("#item-" + v.id).addClass("selected")
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#item-" + v.id).offset().top

            }, 100);
        });

        markers.push(marker)
    })
}

function search_page() {


    var editableLayers = new L.FeatureGroup();
    map.addLayer(editableLayers);

    var drawPluginOptions = {
        position: 'topright',
        draw: {
            polygon: {
                allowIntersection: false,
                drawError: {
                    color: '#e1e100',
                    message: 'Invalid Polygon'
                },
                shapeOptions: {
                    color: '#97009c'
                }
            },

            polyline: false,
            circle: true,
            rectangle: true,
            marker: false,
        },
        edit: {
            featureGroup: editableLayers,
            remove: false
        }
    };

    var drawControl = new L.Control.Draw(drawPluginOptions);
    map.addControl(drawControl);

    var editableLayers = new L.FeatureGroup();
    map.addLayer(editableLayers);

    map.on('draw:created', function(e) {

        clearmap()
        var type = e.layerType,
            layer = e.layer;

        $("#layer_type").val(type)
        $("#area_selected").val("1")

        if (type === 'polygon' || type === 'rectangle') {
            let coords = []
            layer._latlngs[0].forEach(function(v) {
                coords.push(v.lat + " " + v.lng)
            })
            coords.push(layer._latlngs[0][0].lat + " " + layer._latlngs[0][0].lng)
            coords = coords.join(",")
            $("#coords").val(coords)
        } else if (type === 'circle') {

            let coord = layer._latlng.lat + "," + layer._latlng.lng + "," + layer._mRadius * 0.001
            $("#coords").val(coord)
        }

        $(".search-results").hide()

        $(".results-append").html("")

        editableLayers.addLayer(layer);
    });

    




    $("#search-form").submit(function(e) {
        var btn_id = $(this).find("button:focus").attr('id');
        var data = $(this).serialize();
        if (btn_id === 'search') {
            e.preventDefault()
            search(data)
        } else if (btn_id === 'save-search') {
            e.preventDefault()
            if (!authorized) {
                $.toast({
                    heading: 'Error',
                    text: "Please log in to save search",
                    showHideTransition: 'fade',
                    icon: 'error'
                })
            } else {
                $(".leaflet-marker-icon, .leaflet-pane.leaflet-shadow-pane").hide()
                var html2canvasConfiguration = {
                    useCORS: true,
                    width: map._size.x,
                    height: map._size.y,
                    backgroundColor: null,
                    logging: true,
                    imageTimeout: 0
                };

                HTMLCanvasElement.prototype.getContext = function(origFn) {
                return function(type, attribs) {
                    attribs = attribs || {};
                    attribs.preserveDrawingBuffer = true;
                    return origFn.call(this, type, attribs);
                };
                }(HTMLCanvasElement.prototype.getContext);

                var elementToCapture = map._container.getElementsByClassName('leaflet-pane leaflet-map-pane')[0];
                html2canvas(elementToCapture, html2canvasConfiguration).then(function (canvas) {
                    $("#map_base64").val(canvas.toDataURL('image/png'))
                    $(".leaflet-marker-icon, .leaflet-pane.leaflet-shadow-pane").show()
                    $(".search-modal").modal('show')

                })
            }
        } else if (btn_id === 'delete-search') {
            e.preventDefault()
            var dl_url = generate_url('/delete-search/')+""+save_search_id
            // console.log(dl_url)
            window.location.replace(dl_url);
        }
    })


    $("#save-search-form").submit(function(e) {
        e.preventDefault()
        var data = {};

        $.map($("#search-form").serializeArray(), function(n, i){
            data[n['name']] = n['value'];
        });

        if ($("#area_selected").val()) {
            data['has_image'] = 1
            data['image_base64'] = $("#map_base64").val()
        }

        data['save_search_name'] = $("#save_search_name").val()

        data['_token'] = csrf_token

        $.ajax({
            type: "POST",
            url: save === true ? generate_url('/update-search/') + save_search_id: generate_url('/save-search'),
            data: data,
            dataType: "json",
            success: function(data) {
                $.toast({
                    heading: data.success ? 'Success' : 'Error',
                    text: data.message,
                    showHideTransition: 'fade',
                    icon: data.success ? 'success' : 'error'
                })
            },
            error: function(data) {
                console.log(data.responseText)
                $.toast({
                    heading: 'Error',
                    text: data.status === 401 ? "Please log in to save search" : "There was an error",
                    showHideTransition: 'fade',
                    icon: 'error'
                })
            }
        });
        $(".search-modal").modal('hide')
    })






    if (save) {

        $("input,select").each(function() {
            var v = $(this).data('val')
            if (v || v === 0) {
                var t = $(this)
                var delay = t.data('delay')
                if (!delay) {
                    t.val(v)
                    t.change()
                } else {
                    setTimeout(function() {
                        t.val(v)
                        console.log(delay)
                    }, delay)
                }
            }
        })

        var center = []
        if ($("#layer_type").val() === 'polygon' || $("#layer_type").val() === 'rectangle') {
            var lat_lngs = []
            $("#coords").val().split(",").forEach(function(v) {
                v = v.split(" ")
                v[0] = parseFloat(v[0])
                v[1] = parseFloat(v[1])
                lat_lngs.push(v)
            })
            
            var polygon = L.polygon(lat_lngs).addTo(map);

            center.lat = polygon.getBounds().getCenter().lat
            center.long = polygon.getBounds().getCenter().lng

        } else if ($("#layer_type").val() === 'circle') {
            var circle = $("#coords").val().split(",")
            L.circle([circle[0], circle[1]], {radius: circle[2]*1000}).addTo(map);

            center.lat = circle[0]
            center.long = circle[1]
        }

        if ($("#layer_type").val()) {
            map.panTo(new L.LatLng(center.lat, center.long));
        }

        setTimeout(() => {
            var data = $("#search-form").serialize();
            search(data)
        }, 500);
    }
}


function search(data) {
    $(".search-results").hide()

        markers.forEach(function(v) {
            v.remove()
        })
        $.ajax({
            type: "POST",
            url: generate_url('/api/search'),
            data: data,
            dataType: "json",
            success: function(data) {
                console.log(data)
                if (data.results.length > 0) {
                    if (!$("#layer_type").val()) {
                        map.panTo(new L.LatLng(data.results[0].lat, data.results[0].long));
                    }
                    $(".search-results").show()


                    markerdata = []

                    $(".results-append").html("")

                    data.results.forEach(function(v) {

                        markerdata.push(v)
                        showMarkers()

                        let html = `<div class="result-item" id="item-${v.id}">

                            <a href="${generate_url('/property/')}${v.id}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="${v.img}" class="img-fluid" />
                                    </div>
                                    <div class="col-md-8">
                                        <p><b class="text-center">${v.title}</b></p>
                                        <p>${v.type}</p>
                                        <p>${v.bath} Bedrooms</p>
                                        <p>${v.bed} Bathrooms</p>
                                        <p>${v.size}</p>
                                        <p>${v.cost} Tk</p>
                                    </div>
                                </div>
                            </a>

                        </div>`

                        $(".results-append").append(html)
                    })
                } else {
                    console.log(data.sql)
                    $.toast({
                        heading: 'Sorry',
                        text: "No Results were found",
                        showHideTransition: 'fade',
                        icon: 'error'
                    })
                }

            },
            error: function(err) {
                console.log(err)
            }
        });
}

function check_notifications() {

    var notification_url = generate_url('/check-notification')

    $.get(notification_url, function(data, status){
        $("#total_notifications").text(data.unseen > 0 ? `(${data.unseen})` : '')
            data.new.forEach(function(v) {
                let html = `<div class="notification_wrapper">
                    <div class='img'><img src='${v.img}' /></div>
                    <div class='content'>
                        <p>New Property at <a href="${generate_url('/property')}/${v.id}"><b>${v.title}</b></a> matches saved search : <a href="${generate_url('/saved-search')}/${v.save_id}"><b>${v.saved_search_name}</a></b></p>
                    </div>
            </div>`
                $.toast({
                    text : html,
                    hideAfter : false,
                    bgColor : '#e2e1ff',
                    textColor : '#333',
                })

        })
    });
    setTimeout(() => {
        check_notifications()
    }, 5000);
}



var cities = []

cities['Chittagong'] = `Chhagalnaiya
Daganbhuiyan
Parshuram
Sonagazi
Bandarban
Khagrachhari
Rangamati
Rangunia
Sandwip
Fatikchhari
Nazir Hat
Baroiyarhat
Mirsharai
Sitakunda
Hathazari
Raozan
Patiya
Brahmanpara Upazila
Chandanaish
Satkania
Boalkhali
Akhaura
Sarail
Chowmuhani`

cities['Barisal'] = `	
Bhola
Patuakhali
Pirojpur
Jhalokati
Barguna
Amtali
Bakerganj
Char Fasson
Gournadi
Swarupkati
Kuakata
Muwallad
Bhandaria
Mathbaria
Lalmohan
Borhanuddin
Daulatkhan
Banaripara
Mehendiganj
Nalchity
Patharghata
Kalapara
Be`

cities['Dhaka'] = `Mirpur
Mohakhali
Dhanmondi
Gulshan
Banani
Ghorashal
Monohardi
Shibpur
Raipura
Madhabdi
Mirzapur
Dhanbari
Madhupur
Gopalpur
Ghatail
Kalihati
Sakhipur
Bhuapur
Elenga
Karatia
Aricha
Basail
Bhairab
Kishoreganj
Pakundia
Manikganj
Munshiganj
Gopalganj
Shariatpur
Madaripur
Rajbari
Baliakandi
Pangsha`

cities['Khulna'] = `Bagherhat
Chuadanga
Darshana, Chuadanga
Jhenaidah
Kaliganj
Magura
Meherpur
Narail
Noapara`

cities['Mymensigh'] = `Shambhuganj
Muktagachha
Bhaluka
Gouripur
Phulpur
Trishal
Nandail
Gaffargaon
Ishwarganj
Haluaghat
Fulbaria
Netrokona
Sherpur`

cities['Rajshahi'] = `Joypurhat
Rahanpur
Kalai
Khetlal
Akkelpur
Panchbibi
Mundumala
Naogaon
Natore
Shahjadpur
Ullapara
Iswardi
Santhia
Dhunat
Sherpur
Bogra
Tanore`

cities['Rangpur'] = `	
Gaibandha
Kurigram
Lalmonirhat
Nilphamari
Panchagarh
Thakurgaon
Saidpur
Ulipur
Nageshwari
Parbatipur
Badarganj
Pirganj`

cities['Sylet'] = `Maulvibazar
Habiganj
Sunamganj
Maulvibazar
Sreemangal
Kulaura
Beanibazar
Barlekha
Zakiganj
Chhatak
Balagonj
Osmaninogor
Joggonathpur
`
