(function($, window, document) {
    'use strict';

    var imagesWrapper = $('#meta-box-image-cbpw'),
        inputImages = $('#cbp_project_images'),
        jsonInput = (inputImages.val())? inputImages.val() : '[]',
        imagesArr;

    imagesArr = JSON.parse(jsonInput);

    $.each(imagesArr, function(index, item) {
        imagesWrapper.append('<img src="' + item.url + '" alt="" width="200" />');
    });

    $('#meta-box-button-cbpw').on('click.cbp', function(e) {
        e.preventDefault();

        // create new media frame
        // You have to create new frame every time to control the Library state as well as selected images
        var wp_media_frame = wp.media.frames.wp_media_frame = wp.media({
            title: 'My Gallery', // it has no effect but I really want to change the title
            frame: "post",
            toolbar: 'main-gallery',
            state: (imagesArr.length)? 'gallery-edit' : 'gallery-library',
            library: {
                type: 'image'
            },
            multiple: true
        });

        // when open media frame, add the selected image to Gallery
        wp_media_frame.on('open', function() {
            if (!imagesArr.length) {
                return;
            }

            var library = wp_media_frame.state().get('library');

            imagesArr.forEach(function(item) {

                var attachment = wp.media.attachment(item.id);
                attachment.fetch();

                library.add(attachment ? [attachment] : []);

            });
        });

        // when click Insert Gallery, run callback
        wp_media_frame.on('update', function() {

            var library = wp_media_frame.state().get('library');

            imagesWrapper.html('');
            imagesArr = [];

            library.each(function(image) {

                image = image.toJSON();
                imagesArr.push({
                    url: image.url,
                    id: image.id
                });

                imagesWrapper.append('<img src="' + image.url + '" alt="" width="200" />');

            });

            inputImages.val(JSON.stringify(imagesArr));

        });

        wp_media_frame.open();
    });

    $('#meta-box-remove-cbpw').on('click.cbp', function(e) {
        e.preventDefault();

        imagesWrapper.html('');
        imagesArr = [];
        inputImages.val('');

    });

})(jQuery, window, document, undefined);
