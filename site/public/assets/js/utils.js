function isDragSupported() {
    var div = document.createElement('div');
    return ('draggable' in div) || ('ondragstart' in div && 'ondrop' in div);
}

function isImage(file) {
    return file.type.match(/image-*/);
}

function youTubeGetId(url) {
    url = url.split(/(vi\/|v%3D|v=|\/v\/|youtu\.be\/|\/embed\/)/);
    return undefined !== url[2] ? url[2].split(/[^0-9a-z_\-]/i)[0] : url[0];
}

function initGoogleMaps(apiKey) {
    var tag = document.createElement('script');
    tag.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initMap`;
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

function initYoutube() {
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

function saveValue(key, value) {
    if (typeof (Storage) !== "undefined") {
        window.localStorage.setItem(key, value);
    }
}

function getValue(key) {
    if (typeof (Storage) !== "undefined") {
        return window.localStorage.getItem(key);
    }
    return false;
}

function saveDraft(key, data) {
    firestore.collection('drafts').doc(key)
        .set(data)
        .then(function () {
            saveValue('draft', key);
        });
}

function getDraft() {
    return new Promise(function (resolve, reject) {
        var draft = getValue('draft');
        if (draft) {
            console.log(draft);
            firestore.collection('drafts').doc(draft).get().then(function (doc) {
                if (doc.exists) {
                    resolve(doc.data());
                } else {
                    window.localStorage.removeItem('draft');
                    reject('Rascunho nao existe');
                }
            }).catch(function (error) {
                reject(error);
            });
        } else {
            reject('Nenhum rascunho');
        }
    });
}

function removeDraft() {
    return new Promise(function (resolve, reject) {
        var draft = getValue('draft');
        if (draft) {
            console.log(draft);
            firestore.collection('drafts').doc(draft).delete().then(function () {
                resolve('Rascunho excluído');
            }).catch(function (error) {
                reject(error);
            });
        } else {
            reject('Nenhum rascunho para ser excluido');
        }
    });
}

function getLocalizacao() {
    return new Promise(function (resolve, reject) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                getAddress(position.coords.latitude, position.coords.longitude)
                    .then(function (endereco) {
                        resolve(endereco);
                    })
                    .catch(function (error) {
                        reject(error);
                    });
            }, function (error) {
                getGeoByIp()
                    .then(function (localizacao) {
                        getAddress(localizacao.latitude, localizacao.longitude)
                            .then(function (endereco) {
                                resolve(endereco);
                            })
                            .catch(function (error) {
                                reject(error);
                            })
                    })
                    .catch(function (error) {
                        reject(error);
                    });
            });
        } else {
            getGeoByIp()
                .then(function (localizacao) {
                    getAddress(localizacao.latitude, localizacao.longitude)
                        .then(function (endereco) {
                            resolve(endereco);
                        })
                        .catch(function (error) {
                            reject(error);
                        })
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    });
}

function getGeoByIp() {
    return new Promise(function (resolve, reject) {
        fetch('http://api.ipstack.com/189.61.119.231?access_key=7300d36bec0dd947e62162f761292fce')
            .then(function (response) {
                return response.json();
            })
            .then(function (json) {
                resolve({latitude: json.latitude, longitude: json.longitude});
            })
            .catch(function (error) {
                reject(error);
            });
    });

}

function getAddress(lat, lon) {
    return new Promise(function (resolve, reject) {
        saveValue('lat', lat);
        saveValue('lon', lon);
        var body = {
            "from": 0, "size": 1,
            "sort": [
                {
                    "_geo_distance": {
                        "localizacao": {
                            "lat": lat,
                            "lon": lon
                        },
                        "order": "asc",
                        "unit": "km",
                        "distance_type": "plane"
                    }
                }
            ]
        };
        fetch('https://search-tiger-strips-4fbdu7i2q6p7uhsxyaecyzqhbu.sa-east-1.es.amazonaws.com/enderecos/_search', {
            method: "POST",
            headers: {
                "Content-Type": "application/json; charset=utf-8"
            },
            body: JSON.stringify(body)
        }).then(function (response) {
            return response.json();
        }).then(function (result) {
            resolve(result.hits.hits[0]._source);
        }).catch(function (error) {
            reject(error);
        });
    });
}