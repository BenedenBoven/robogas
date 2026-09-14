import './plugins/modulobox.js';

// Modulobox
const modulobox = new ModuloBox({
    mediaSelector:      '.gallery figure > a, .hidden-gallery div',
    loop:               3,
    history:            true,
    controls:           ['zoom', 'play', 'fullScreen', 'download', 'share', 'close'],
    shareButtons:       [],
    videoMaxWidth:      1440,
    minZoom:            1,
    zoomTo:             1.8,
    autoplay:           true,
    mouseWheel:         false,
    contextMenu:        false,
    scrollToZoom:       true,
    captionSmallDevice: false,
    thumbnails:         true,
    thumbnailsNav:      'centered',
    thumbnailSizes:     {
        1920: {
            width:  110,
            height: 80,
            gutter: 10
        },
        1280: {
            width:  90,
            height: 65,
            gutter: 10
        },
        680:  {
            width:  0,
            height: 0,
            gutter: 0
        }
    }
});

modulobox.on('beforeOpen.modulobox', function(gallery, index) {
    if(window.cubeRAF) {
        cancelAnimationFrame(window.cubeRAF);
        window.cubeRAF = false;
    }
});

modulobox.on('afterClose.modulobox', function(gallery, index) {
    if(typeof Event === 'function' && !window.cubeRAF) {
        window.dispatchEvent(new Event('scroll'));
    }
});

modulobox.init();