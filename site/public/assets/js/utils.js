function isDragSupported() {
    var div = document.createElement('div');
    return ('draggable' in div) || ('ondragstart' in div && 'ondrop' in div);
}

function isImage(file){
    return file.type.match(/image-*/);
}

function youTubeGetId(url){
    url = url.split(/(vi\/|v%3D|v=|\/v\/|youtu\.be\/|\/embed\/)/);
    return undefined !== url[2]?url[2].split(/[^0-9a-z_\-]/i)[0]:url[0];
}

function initGoogleMaps(apiKey){
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

function saveValue(key, value){
    if (typeof(Storage) !== "undefined") {
        window.localStorage.setItem(key, value);
    }
}

function getValue(key){
    if (typeof(Storage) !== "undefined") {
        return window.localStorage.getItem(key);
    }
    return false;
}